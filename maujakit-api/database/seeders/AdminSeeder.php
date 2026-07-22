<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::truncate();

        Admin::create([
            'name'       => 'Owner MauJahit',
            'login_code' => 'OWNER2026',
            'role'       => 'owner'
        ]);

        Admin::create([
            'name'       => 'Admin CS',
            'login_code' => 'CS2026',
            'role'       => 'admin_cs'
        ]);

        Admin::create([
            'name'       => 'Admin Produksi',
            'login_code' => 'PRODUKSI2026',
            'role'       => 'admin_produksi'
        ]);

        Admin::create([
            'name'       => 'Keuangan',
            'login_code' => 'KEUANGAN2026',
            'role'       => 'keuangan'
        ]);

        Admin::create([
            'name'       => 'Gudang Packing',
            'login_code' => 'GUDANG2026',
            'role'       => 'gudang'
        ]);
    }
}
