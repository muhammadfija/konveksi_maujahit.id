<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Public endpoint — no auth required.
     */
    public function show(string $code): JsonResponse
    {
        $order = Order::with(['progresses' => function($q) {
            $q->oldest();
        }])
            ->where('tracking_code', strtoupper(trim($code)))
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tracking tidak ditemukan.',
            ], 404);
        }

        $stages = Order::$stages;
        $stageLabels = Order::$stageLabels;

        $completedStages = collect($stages)->take(
            array_search($order->current_status, $stages) + 1
        )->values();

        $timeline = collect($stages)->map(function ($stage, $index) use ($order, $stageLabels, $completedStages) {
            $currentIndex = array_search($order->current_status, Order::$stages);
            $stageIndex   = $index;

            if ($stageIndex < $currentIndex) {
                $statusType = 'done';
            } elseif ($stageIndex === $currentIndex) {
                $statusType = 'current';
                if (!in_array($order->current_status, ['SELESAI', 'PENGIRIMAN']) && now()->startOfDay()->gt(\Carbon\Carbon::parse($order->estimated_finish)->startOfDay())) {
                    $statusType = 'late';
                }
            } else {
                $statusType = 'pending';
            }

            // Find progress records for this stage
            $progressesForStage = $order->progresses->where('status', $stage);
            $latestProgress = $progressesForStage->last();
            $photoProgress  = $progressesForStage->firstWhere('photo_path', '!=', null);

            return [
                'stage'      => $stage,
                'label'      => $stageLabels[$stage],
                'status'     => $statusType,
                'date'       => $latestProgress ? $latestProgress->created_at->format('d M Y, H:i') : null,
                'note'       => $latestProgress?->note,
                'photo_url'  => $photoProgress && $photoProgress->photo_path ? asset('storage/' . $photoProgress->photo_path) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'tracking_code'      => $order->tracking_code,
                'customer_name'      => $order->customer_name,
                'whatsapp'           => $order->whatsapp,
                'company_name'       => $order->company_name,
                'product_type'       => $order->product_type,
                'quantity'           => $order->quantity,
                'color'              => $order->color,
                'notes'              => $order->notes,
                'estimated_finish'   => $order->estimated_finish->format('d M Y'),
                'created_at'         => $order->created_at->format('d M Y'),
                'current_status'     => $order->current_status,
                'current_status_label' => Order::$stageLabels[$order->current_status] ?? $order->current_status,
                'progress_percentage' => $order->progress_percentage,
                'resi_number'        => $order->resi_number,
                'timeline'           => $timeline,
            ],
        ]);
    }
}
