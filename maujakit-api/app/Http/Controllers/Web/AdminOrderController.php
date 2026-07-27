<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductionProgress;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminOrderController extends Controller
{
    public function dashboard(\Illuminate\Http\Request $request)
    {
        $startDate = $request->start_date ? \Carbon\Carbon::parse($request->start_date)->startOfDay() : now()->startOfMonth();
        $endDate = $request->end_date ? \Carbon\Carbon::parse($request->end_date)->endOfDay() : now()->endOfMonth();
        $stats = [
            'total'       => Order::count(),
            'in_progress' => Order::whereNotIn('current_status', ['ORDER_MASUK', 'KIRIM'])->count(),
            'completed'   => Order::where('current_status', 'KIRIM')->count(),
            'wait_payment'=> Order::where('current_status', 'DP_PELUNASAN')->count(),
            'terlambat'   => Order::whereNotIn('current_status', ['KIRIM'])->whereDate('estimated_finish', '<', now()->startOfDay())->count(),
            'deadline_hari_ini' => Order::whereNotIn('current_status', ['KIRIM'])->whereDate('estimated_finish', today())->count(),
            'selesai_hari_ini' => Order::where('current_status', 'KIRIM')->whereDate('updated_at', today())->count(),
            'menunggu_pengiriman' => Order::where('current_status', 'PACKING')->count(),
            'belum_lunas' => Order::where('current_status', 'DP_PELUNASAN')->count(),
            'prioritas'   => Order::where('is_priority', true)->whereNotIn('current_status', ['KIRIM'])->count(),
            'non_prioritas'=> Order::where('is_priority', false)->whereNotIn('current_status', ['KIRIM'])->count(),
            'potong'      => Order::where('current_status', 'POTONG')->count(),
            'jahit'       => Order::where('current_status', 'JAHIT')->count(),
            'qc'          => Order::where('current_status', 'QC')->count(),
            'packing'     => Order::where('current_status', 'PACKING')->count(),
            'kirim'       => Order::where('current_status', 'KIRIM')->count(),
        ];

        // Omzet & Order Stats
        $stats['total_order_bulan_ini'] = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $stats['omzet_bulan_ini'] = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_price');
        $stats['order_selesai'] = Order::where('current_status', 'KIRIM')->count();
        $stats['order_berjalan'] = Order::whereNotIn('current_status', ['KIRIM'])->count();

        // Customer Baru vs Repeat Order
        $ordersThisMonth = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        
        $newCustomers = 0;
        $repeatOrders = 0;
        $processedWa = [];
        
        foreach ($ordersThisMonth as $order) {
            $wa = $order->whatsapp;
            if (!in_array($wa, $processedWa)) {
                $previousOrders = Order::where('whatsapp', $wa)
                                       ->where('created_at', '<', now()->startOfMonth())
                                       ->count();
                if ($previousOrders == 0) {
                    $newCustomers++;
                } else {
                    $repeatOrders++;
                }
                $processedWa[] = $wa;
            } else {
                $repeatOrders++;
            }
        }
        $stats['customer_baru'] = $newCustomers;
        $stats['repeat_order'] = $repeatOrders;

        // Data for Chart.js
        $daysDiff = $startDate->diffInDays($endDate);
        if ($daysDiff > 90) $daysDiff = 90; // Limit to 90 days to prevent chart overload

        $chartDates = [];
        $chartOmzet = [];
        $chartOrders = [];
        
        for ($i = 0; $i <= $daysDiff; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $chartDates[] = $startDate->copy()->addDays($i)->format('d M');
            
            // Get daily sums
            $chartOmzet[] = Order::whereDate('created_at', $date)->sum('total_price');
            $chartOrders[] = Order::whereDate('created_at', $date)->count();
        }
        
        $chartData = [
            'labels' => $chartDates,
            'omzet' => $chartOmzet,
            'orders' => $chartOrders
        ];

        $totalTargetHariIni = $stats['deadline_hari_ini'] + $stats['selesai_hari_ini'];
        $stats['target_produksi_persen'] = $totalTargetHariIni > 0 
            ? round(($stats['selesai_hari_ini'] / $totalTargetHariIni) * 100) 
            : 0;

        $recentOrdersQuery = Order::query()->latest();
        $deadlineOrdersQuery = Order::whereNotIn('current_status', ['KIRIM'])
                                    ->whereDate('estimated_finish', '<=', now()->addDays(7))
                                    ->orderBy('estimated_finish', 'asc');

        if (session('admin_role') === 'admin_produksi') {
            $recentOrdersQuery->whereIn('current_status', ['POTONG', 'JAHIT', 'QC']);
            $deadlineOrdersQuery->whereIn('current_status', ['POTONG', 'JAHIT', 'QC']);
        } elseif (session('admin_role') === 'gudang') {
            $recentOrdersQuery->whereIn('current_status', ['PACKING', 'KIRIM']);
            $deadlineOrdersQuery->whereIn('current_status', ['PACKING', 'KIRIM']);
        }

        $recentOrders = $recentOrdersQuery->take(5)->get();
        $deadlineOrders = $deadlineOrdersQuery->take(5)->get();

        $productionBreakdown = [
            'potong_jahit' => Order::whereIn('current_status', ['POTONG', 'JAHIT'])->count(),
            'sablon_bordir' => Order::where('current_status', 'BELI_BAHAN')->count(),
            'finishing' => Order::whereIn('current_status', ['QC', 'PACKING'])->count(),
        ];

        return view('admin.dashboard', compact('stats', 'recentOrders', 'deadlineOrders', 'productionBreakdown', 'chartData'));
    }

    public function exportExcel(\Illuminate\Http\Request $request)
    {
        abort_if(!in_array(session('admin_role'), ['owner', 'admin_cs', 'keuangan']), 403, 'Akses Ditolak.');

        $startDate = $request->start_date ? \Carbon\Carbon::parse($request->start_date)->startOfDay() : now()->startOfMonth();
        $endDate = $request->end_date ? \Carbon\Carbon::parse($request->end_date)->endOfDay() : now()->endOfMonth();

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'asc')->get();

        $filename = "Laporan_Pesanan_" . $startDate->format('Ymd') . "_" . $endDate->format('Ymd') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($orders) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fputs($file, "\xEF\xBB\xBF");
            
            // CSV Header
            fputcsv($file, [
                'Kode Tracking', 
                'Pelanggan', 
                'No. WhatsApp', 
                'Instansi', 
                'Produk', 
                'Warna',
                'Jumlah', 
                'Total Harga (Rp)', 
                'Status Produksi', 
                'Tanggal Pesan', 
                'Estimasi Selesai'
            ], ';');

            // Data Rows
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->tracking_code,
                    $order->customer_name,
                    "'" . $order->whatsapp, // Prefix with apostrophe to prevent scientific notation in Excel
                    $order->company_name ?: '-',
                    $order->product_type,
                    $order->color,
                    $order->quantity,
                    $order->total_price,
                    Order::$stageLabels[$order->current_status] ?? $order->current_status,
                    $order->created_at ? "'" . $order->created_at->format('d-m-Y') : '-',
                    $order->estimated_finish ? "'" . $order->estimated_finish->format('d-m-Y') : '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index(Request $request)
    {
        $query = Order::query()->latest();
        $role = session('admin_role');

        if ($role === 'admin_produksi') {
            $query->whereIn('current_status', ['POTONG', 'JAHIT', 'QC']);
        } elseif ($role === 'gudang') {
            $query->whereIn('current_status', ['PACKING', 'KIRIM']);
        }

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

        $orders = $query->paginate(5);
        $stages = Order::$stages;
        
        if ($role === 'admin_produksi') {
            $stages = ['POTONG', 'JAHIT', 'QC'];
        } elseif ($role === 'gudang') {
            $stages = ['PACKING', 'KIRIM'];
        }

        $stageLabels = Order::$stageLabels;

        return view('admin.orders.index', compact('orders', 'stages', 'stageLabels'));
    }

    public function create()
    {
        abort_if(!in_array(session('admin_role'), ['owner', 'admin_cs']), 403, 'Akses Ditolak. Hanya Owner dan Admin CS yang dapat menambah pesanan.');
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        abort_if(!in_array(session('admin_role'), ['owner', 'admin_cs']), 403, 'Akses Ditolak.');

        if ($request->product_type === 'Lainnya' && $request->filled('custom_product_type')) {
            $request->merge(['product_type' => $request->custom_product_type]);
        }

        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'whatsapp'         => 'required|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'product_type'     => 'required|string|max:255',
            'quantity'         => 'required|integer|min:1',
            'color'            => 'required|string|max:255',
            'notes'            => 'nullable|string',
            'total_price'      => 'nullable|numeric|min:0',
            'estimated_finish' => 'required|date',
            'is_priority'      => 'nullable|boolean',
        ]);

        $validated['tracking_code']  = Order::generateTrackingCode();
        $validated['current_status'] = 'ORDER_MASUK';
        $validated['is_priority']    = $request->boolean('is_priority');

        $order = Order::create($validated);

        ProductionProgress::create([
            'order_id'   => $order->id,
            'status'     => 'ORDER_MASUK',
            'note'       => 'Pesanan telah diterima.',
            'created_by' => session('admin_name', 'Admin'),
        ]);

        return redirect('/admin/pesanan/' . $order->id)->with('success', 'Pesanan berhasil dibuat dengan kode tracking: ' . $order->tracking_code);
    }

    public function show(string $id)
    {
        $order = Order::with(['progresses' => function($q) {
            $q->oldest();
        }])->findOrFail($id);
        
        $stages = Order::$stages;
        $stageLabels = Order::$stageLabels;
        
        $timeline = collect($stages)->map(function ($stage, $index) use ($order, $stageLabels) {
            $currentIndex = array_search($order->current_status, Order::$stages);
            
            if ($index < $currentIndex) {
                $statusType = 'done';
            } elseif ($index === $currentIndex) {
                $statusType = 'current';
                if (!in_array($order->current_status, ['KIRIM']) && now()->startOfDay()->gt(\Carbon\Carbon::parse($order->estimated_finish)->startOfDay())) {
                    $statusType = 'late';
                }
            } else {
                $statusType = 'pending';
            }

            $progressesForStage = $order->progresses->where('status', $stage);
            $latestProgress = $progressesForStage->last(); // most recent entry for this stage
            $photoProgress  = $progressesForStage->firstWhere('photo_path', '!=', null); // entry with photo

            return [
                'stage'     => $stage,
                'label'     => $stageLabels[$stage],
                'status'    => $statusType,
                'date'      => $latestProgress ? $latestProgress->created_at->format('d M Y, H:i') : null,
                'note'      => $latestProgress?->note,
                'photo_url' => $photoProgress && $photoProgress->photo_path ? asset('storage/' . $photoProgress->photo_path) : null,
            ];
        });

        return view('admin.orders.show', compact('order', 'stages', 'stageLabels', 'timeline'));
    }

    public function update(Request $request, string $id)
    {
        abort_if(!in_array(session('admin_role'), ['owner', 'admin_cs']), 403, 'Akses Ditolak.');

        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'whatsapp'         => 'required|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'product_type'     => 'required|string|max:255',
            'quantity'         => 'required|integer|min:1',
            'color'            => 'required|string|max:255',
            'notes'            => 'nullable|string',
            'total_price'      => 'nullable|numeric|min:0',
            'estimated_finish' => 'required|date',
            'resi_number'      => 'nullable|string|max:100',
            'is_priority'      => 'nullable|boolean',
        ]);

        $validated['is_priority'] = $request->boolean('is_priority');

        $order->update($validated);

        return redirect('/admin/pesanan/' . $order->id)->with('success', 'Informasi pesanan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        abort_if(!in_array(session('admin_role'), ['owner', 'admin_cs']), 403, 'Akses Ditolak. Hanya Owner dan Admin CS yang dapat menghapus pesanan.');

        $order = Order::findOrFail($id);
        $order->delete();

        return redirect('/admin/pesanan')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, string $id)
    {
        abort_if(!in_array(session('admin_role'), ['owner', 'admin_cs', 'admin_produksi', 'gudang']), 403, 'Akses Ditolak.');

        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(Order::$stages)],
            'note'   => 'nullable|string',
        ]);

        if (session('admin_role') === 'admin_produksi' && !in_array($validated['status'], ['POTONG', 'JAHIT', 'QC'])) {
            abort(403, 'Akses Ditolak. Admin produksi hanya dapat mengubah status ke Potong, Jahit, atau QC.');
        }

        if (session('admin_role') === 'gudang' && !in_array($validated['status'], ['PACKING', 'KIRIM'])) {
            abort(403, 'Akses Ditolak. Admin gudang hanya dapat mengubah status ke Packing atau Kirim.');
        }

        $newStatus = $validated['status'];
        $order->update(['current_status' => $newStatus]);

        ProductionProgress::create([
            'order_id'   => $order->id,
            'status'     => $newStatus,
            'note'       => $validated['note'] ?? (Order::$stageLabels[$newStatus] . ' sedang diproses.'),
            'created_by' => session('admin_name', 'Admin'),
        ]);

        // Send WhatsApp Notification for specific statuses
        if (in_array($newStatus, ['DESAIN', 'JAHIT', 'PACKING', 'KIRIM'])) {
            $customerName = $order->customer_name;
            $productType = $order->product_type;
            
            $waMessage = "";
            if ($newStatus === 'DESAIN') {
                $waMessage = "Halo Kak *$customerName*,\n\nDesain untuk pesanan *$productType* Kakak telah disetujui. Kami akan segera memproses ke tahap selanjutnya. Terima kasih! 🙏";
            } elseif ($newStatus === 'JAHIT') {
                $waMessage = "Halo Kak *$customerName*,\n\nKabar baik! Pesanan *$productType* Kakak saat ini sudah masuk ke tahap *Produksi Jahit*. Kami akan terus memberikan update perkembangan pesanan Kakak. 🙏";
            } elseif ($newStatus === 'PACKING') {
                $waMessage = "Halo Kak *$customerName*,\n\nPesanan *$productType* Kakak telah *Selesai QC (Quality Control)* dan saat ini sedang dalam proses packing/pengemasan. Siap-siap untuk tahap pengiriman! 📦✨";
            } elseif ($newStatus === 'KIRIM') {
                $resi = $order->resi_number ? "\nNomor Resi: *$order->resi_number*" : "";
                $waMessage = "Halo Kak *$customerName*,\n\nYay! Pesanan *$productType* Kakak sedang *Dikirim* menuju lokasi Kakak. Mohon ditunggu kedatangannya ya! 🚚$resi";
            }

            if ($waMessage && $order->whatsapp) {
                \App\Services\FonnteService::send($order->whatsapp, $waMessage);
            }
        }

        return redirect('/admin/pesanan/' . $order->id)->with('success', 'Status produksi berhasil diperbarui.');
    }

    public function uploadPhoto(Request $request, $id)
    {
        abort_if(!in_array(session('admin_role'), ['owner', 'admin_cs', 'admin_produksi', 'gudang']), 403, 'Akses Ditolak.');

        $order = Order::findOrFail($id);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'note'  => 'nullable|string',
        ]);

        $path = $request->file('photo')->store('progress-photos', 'public');

        ProductionProgress::create([
            'order_id'   => $order->id,
            'status'     => $order->current_status,
            'photo_path' => $path,
            'note'       => $request->note ?? 'Foto progres diunggah.',
            'created_by' => session('admin_name', 'Admin'),
        ]);

        return redirect('/admin/pesanan/' . $order->id)->with('success', 'Foto progres berhasil diunggah.');
    }
}
