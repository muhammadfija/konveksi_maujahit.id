<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductionProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Order::query()->latest();

        if ($request->has('status') && $request->status) {
            $query->where('current_status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data'    => $orders,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'whatsapp'         => 'required|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'product_type'     => 'required|string|max:255',
            'quantity'         => 'required|integer|min:1',
            'color'            => 'required|string|max:255',
            'notes'            => 'nullable|string',
            'estimated_finish' => 'required|date',
        ]);

        $validated['tracking_code']  = Order::generateTrackingCode();
        $validated['current_status'] = 'ORDER_MASUK';

        $order = Order::create($validated);

        // Create initial progress record
        ProductionProgress::create([
            'order_id'   => $order->id,
            'status'     => 'ORDER_MASUK',
            'note'       => 'Pesanan telah diterima.',
            'created_by' => $request->user('sanctum')->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat.',
            'data'    => $order,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $order = Order::with('progresses')->findOrFail($id);

        $stages     = Order::$stages;
        $stageLabels = Order::$stageLabels;

        $timeline = collect($stages)->map(function ($stage, $index) use ($order, $stageLabels) {
            $currentIndex = array_search($order->current_status, Order::$stages);
            $stageIndex   = $index;

            if ($stageIndex < $currentIndex)      $statusType = 'done';
            elseif ($stageIndex === $currentIndex) $statusType = 'current';
            else                                   $statusType = 'pending';

            $progress = $order->progresses->firstWhere('status', $stage);

            return [
                'stage'     => $stage,
                'label'     => $stageLabels[$stage],
                'status'    => $statusType,
                'date'      => $progress ? $progress->created_at->format('d M Y, H:i') : null,
                'note'      => $progress?->note,
                'photo_url' => $progress?->photo_url,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => array_merge($order->toArray(), [
                'progress_percentage'  => $order->progress_percentage,
                'current_status_label' => Order::$stageLabels[$order->current_status] ?? $order->current_status,
                'timeline'             => $timeline,
            ]),
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_name'    => 'sometimes|string|max:255',
            'whatsapp'         => 'sometimes|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'product_type'     => 'sometimes|string|max:255',
            'quantity'         => 'sometimes|integer|min:1',
            'color'            => 'sometimes|string|max:255',
            'notes'            => 'nullable|string',
            'estimated_finish' => 'sometimes|date',
            'resi_number'      => 'nullable|string|max:100',
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil diperbarui.',
            'data'    => $order,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dihapus.',
        ]);
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(Order::$stages)],
            'note'   => 'nullable|string',
        ]);

        $oldStatus = $order->current_status;
        $newStatus = $validated['status'];

        $order->update(['current_status' => $newStatus]);

        // Create progress record
        ProductionProgress::create([
            'order_id'   => $order->id,
            'status'     => $newStatus,
            'note'       => $validated['note'] ?? (Order::$stageLabels[$newStatus] . ' sedang diproses.'),
            'created_by' => $request->user('sanctum')->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status produksi berhasil diperbarui.',
            'data'    => [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'progress'   => $order->progress_percentage,
            ],
        ]);
    }

    public function uploadPhoto(Request $request, int $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'note'  => 'nullable|string',
        ]);

        $path = $request->file('photo')->store('progress-photos', 'public');

        $progress = ProductionProgress::create([
            'order_id'   => $order->id,
            'status'     => $order->current_status,
            'photo_path' => $path,
            'note'       => $request->note ?? 'Foto progres diunggah.',
            'created_by' => $request->user('sanctum')->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto progres berhasil diunggah.',
            'data'    => [
                'photo_url' => asset('storage/' . $path),
                'note'      => $progress->note,
            ],
        ]);
    }

    public function stats(): JsonResponse
    {
        $total        = Order::count();
        // Dalam proses = semua kecuali ORDER_MASUK dan KIRIM
        $inProgress   = Order::whereNotIn('current_status', ['ORDER_MASUK', 'KIRIM'])->count();
        // Selesai = sudah sampai tahap KIRIM (tahap terakhir)
        $completed    = Order::where('current_status', 'KIRIM')->count();
        // Menunggu pelunasan = sedang di tahap DP/Pelunasan
        $waitPayment  = Order::where('current_status', 'DP_PELUNASAN')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total'        => $total,
                'in_progress'  => $inProgress,
                'completed'    => $completed,
                'wait_payment' => $waitPayment,
            ],
        ]);
    }
}
