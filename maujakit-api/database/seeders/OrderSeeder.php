<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Order;
use App\Models\ProductionProgress;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();

        $orders = [
            [
                'tracking_code'    => 'MJK-9X2L7Q',
                'customer_name'    => 'PT Maju Jaya',
                'whatsapp'         => '081234567890',
                'company_name'     => 'PT Maju Jaya',
                'product_type'     => 'Kaos Combed 24s',
                'quantity'         => 500,
                'color'            => 'Navy, Putih',
                'notes'            => 'Lengan Pendek',
                'estimated_finish' => '2024-07-24',
                'current_status'   => 'JAHIT',
            ],
            [
                'tracking_code'    => 'MJK-8K7P2A',
                'customer_name'    => 'Distro Keren',
                'whatsapp'         => '081234567891',
                'company_name'     => 'Distro Keren',
                'product_type'     => 'Hoodie Premium',
                'quantity'         => 100,
                'color'            => 'Hitam',
                'notes'            => null,
                'estimated_finish' => '2024-07-22',
                'current_status'   => 'BELI_BAHAN',
            ],
            [
                'tracking_code'    => 'MJK-2L9D3F',
                'customer_name'    => 'Sekolah Harapan',
                'whatsapp'         => '081234567892',
                'company_name'     => 'Sekolah Harapan',
                'product_type'     => 'Poloshirt',
                'quantity'         => 300,
                'color'            => 'Biru Dongker',
                'notes'            => 'Bordir logo sekolah',
                'estimated_finish' => '2024-07-20',
                'current_status'   => 'QC',
            ],
            [
                'tracking_code'    => 'MJK-7H3K8L',
                'customer_name'    => 'Komunitas Motor',
                'whatsapp'         => '081234567893',
                'company_name'     => null,
                'product_type'     => 'Jaket Varsity',
                'quantity'         => 50,
                'color'            => 'Merah, Putih',
                'notes'            => null,
                'estimated_finish' => '2024-07-18',
                'current_status'   => 'PACKING',
            ],
            [
                'tracking_code'    => 'MJK-1A2B3C',
                'customer_name'    => 'Toko Fashion',
                'whatsapp'         => '081234567894',
                'company_name'     => 'Toko Fashion',
                'product_type'     => 'Kaos Oversize',
                'quantity'         => 200,
                'color'            => 'Cream, Abu-abu',
                'notes'            => null,
                'estimated_finish' => '2024-07-17',
                'current_status'   => 'DP_PELUNASAN',
            ],
        ];

        foreach ($orders as $orderData) {
            $order = Order::create($orderData);

            // Seed progress history
            $stages = Order::$stages;
            $currentIndex = array_search($order->current_status, $stages);

            for ($i = 0; $i <= $currentIndex; $i++) {
                ProductionProgress::create([
                    'order_id'   => $order->id,
                    'status'     => $stages[$i],
                    'note'       => Order::$stageLabels[$stages[$i]] . ' telah selesai.',
                    'created_by' => $admin?->name ?? 'Admin',
                    'created_at' => now()->subDays($currentIndex - $i + 1),
                    'updated_at' => now()->subDays($currentIndex - $i + 1),
                ]);
            }
        }
    }
}
