@extends('layouts.admin')

@section('title', 'Dashboard - Admin MauJahit.id')

@section('content')
<div class="p-4 lg:p-6 animate-fade-in-up">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-500">Ringkasan aktivitas dan status produksi hari ini.</p>
        </div>
        
        @if(in_array(session('admin_role', 'owner'), ['owner', 'admin_cs', 'keuangan']))
        <form action="{{ url('/admin/dashboard') }}" method="GET" class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-1 shadow-sm">
            <input type="date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" class="border-none bg-transparent rounded-lg px-2 py-1.5 text-sm focus:ring-0 text-gray-700 w-32 sm:w-36" onchange="this.form.submit()" title="Dari Tanggal">
            <span class="text-gray-400 font-bold">-</span>
            <input type="date" name="end_date" value="{{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}" class="border-none bg-transparent rounded-lg px-2 py-1.5 text-sm focus:ring-0 text-gray-700 w-32 sm:w-36" onchange="this.form.submit()" title="Sampai Tanggal">
            
            <a href="{{ url('/admin/dashboard/export') }}?start_date={{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}&end_date={{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}" class="ml-2 flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 rounded-lg text-sm font-semibold transition-colors border border-green-200" title="Download Laporan Excel (CSV)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </a>
        </form>
        @endif
    </div>

    @if(session('admin_role') === 'admin_produksi')
        <!-- Dashboard Produksi -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-4">
            <!-- Potong -->
            <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-semibold text-indigo-600 mb-1 uppercase tracking-wide">Tahap Potong</p>
                    <h3 class="text-4xl font-black text-indigo-700 leading-none">{{ number_format($stats['potong']) }} <span class="text-lg font-medium text-indigo-600">Order</span></h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-indigo-200 text-indigo-700 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </div>

            <!-- Jahit -->
            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-semibold text-blue-600 mb-1 uppercase tracking-wide">Tahap Jahit</p>
                    <h3 class="text-4xl font-black text-blue-700 leading-none">{{ number_format($stats['jahit']) }} <span class="text-lg font-medium text-blue-600">Order</span></h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-blue-200 text-blue-700 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </div>

            <!-- QC -->
            <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-semibold text-emerald-600 mb-1 uppercase tracking-wide">Tahap QC</p>
                    <h3 class="text-4xl font-black text-emerald-700 leading-none">{{ number_format($stats['qc']) }} <span class="text-lg font-medium text-emerald-600">Order</span></h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-emerald-200 text-emerald-700 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    @elseif(session('admin_role') === 'gudang')
        <!-- Dashboard Gudang -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 mt-4">
            <!-- Packing -->
            <div class="bg-pink-50 rounded-2xl p-6 border border-pink-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-semibold text-pink-600 mb-1 uppercase tracking-wide">Tahap Packing</p>
                    <h3 class="text-4xl font-black text-pink-700 leading-none">{{ number_format($stats['packing']) }} <span class="text-lg font-medium text-pink-600">Order</span></h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-pink-200 text-pink-700 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>

            <!-- Kirim -->
            <div class="bg-green-50 rounded-2xl p-6 border border-green-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-semibold text-green-600 mb-1 uppercase tracking-wide">Siap Kirim</p>
                    <h3 class="text-4xl font-black text-green-700 leading-none">{{ number_format($stats['kirim']) }} <span class="text-lg font-medium text-green-600">Order</span></h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-green-200 text-green-700 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
            </div>
        </div>
    @endif

    @if(in_array(session('admin_role'), ['owner', 'admin_cs']))
    <!-- Prioritas & Indikator -->
    <div class="mb-8">
        <h2 class="font-bold text-gray-900 mb-4">Prioritas & Indikator</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
            
            <!-- Pesanan Prioritas -->
            <div class="bg-rose-50 rounded-2xl p-4 border border-rose-100 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-rose-600 mb-1 uppercase tracking-wide">Prioritas</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-rose-700 leading-none">{{ number_format($stats['prioritas']) }}</h3>
                    <span class="text-sm font-medium text-rose-600 mb-0.5">Order</span>
                </div>
            </div>

            <!-- Pesanan Normal -->
            <div class="bg-indigo-50 rounded-2xl p-4 border border-indigo-100 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-indigo-600 mb-1 uppercase tracking-wide">Normal</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-indigo-700 leading-none">{{ number_format($stats['non_prioritas']) }}</h3>
                    <span class="text-sm font-medium text-indigo-600 mb-0.5">Order</span>
                </div>
            </div>

            <!-- Terlambat Produksi -->
            <div class="bg-red-50 rounded-2xl p-4 border border-red-100 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-red-600 mb-1 uppercase tracking-wide">Terlambat</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-red-700 leading-none">{{ number_format($stats['terlambat']) }}</h3>
                    <span class="text-sm font-medium text-red-600 mb-0.5">Order</span>
                </div>
            </div>

            <!-- Deadline Hari Ini -->
            <div class="bg-orange-50 rounded-2xl p-4 border border-orange-100 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-orange-600 mb-1 uppercase tracking-wide">Deadline Hari Ini</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-orange-700 leading-none">{{ number_format($stats['deadline_hari_ini']) }}</h3>
                    <span class="text-sm font-medium text-orange-600 mb-0.5">Order</span>
                </div>
            </div>

            <!-- Selesai Hari Ini -->
            <div class="bg-green-50 rounded-2xl p-4 border border-green-100 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-green-600 mb-1 uppercase tracking-wide">Selesai Hari Ini</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-green-700 leading-none">{{ number_format($stats['selesai_hari_ini']) }}</h3>
                    <span class="text-sm font-medium text-green-600 mb-0.5">Order</span>
                </div>
            </div>

            <!-- Menunggu Pengiriman -->
            <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-blue-600 mb-1 uppercase tracking-wide">Siap Kirim</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-blue-700 leading-none">{{ number_format($stats['menunggu_pengiriman']) }}</h3>
                    <span class="text-sm font-medium text-blue-600 mb-0.5">Order</span>
                </div>
            </div>

            <!-- Belum Lunas -->
            <div class="bg-purple-50 rounded-2xl p-4 border border-purple-100 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-purple-600 mb-1 uppercase tracking-wide">Belum Lunas</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-purple-700 leading-none">{{ number_format($stats['belum_lunas']) }}</h3>
                    <span class="text-sm font-medium text-purple-600 mb-0.5">Order</span>
                </div>
            </div>

            <!-- Target Produksi Hari Ini (%) -->
            <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm flex flex-col justify-center hover:shadow-md transition-shadow">
                <p class="text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Target Produksi</p>
                <div class="flex items-end gap-1">
                    <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $stats['target_produksi_persen'] }}<span class="text-xl text-gray-500 font-bold">%</span></h3>
                </div>
                <!-- Mini Progress Bar inside the widget -->
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3">
                    <div class="bg-gray-800 h-1.5 rounded-full" style="width: {{ $stats['target_produksi_persen'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    @endif

    <!-- Performa Berdasarkan Filter -->
    @if(in_array(session('admin_role', 'owner'), ['owner', 'keuangan']))
    <div class="mb-8">
        <h2 class="font-bold text-gray-900 mb-4">
            Performa {{ request('start_date') || request('end_date') ? 'Berdasarkan Filter' : 'Bulan Ini' }}
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Cards (Left) -->
            <div class="lg:col-span-1 grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Total Order</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['total_order_bulan_ini']) }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Omzet</p>
                    <h3 class="text-lg font-black text-green-600">Rp {{ number_format($stats['omzet_bulan_ini'], 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Order Selesai</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['order_selesai']) }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Order Berjalan</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['order_berjalan']) }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Customer Baru</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['customer_baru']) }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Repeat Order</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['repeat_order']) }}</h3>
                </div>
            </div>

            <!-- Chart (Right) -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
                <h3 class="text-sm font-bold text-gray-700 mb-4">Grafik Omzet & Order {{ request('start_date') || request('end_date') ? 'Filter' : 'Bulan Ini' }}</h3>
                <div class="relative h-64 w-full">
                    <canvas id="omzetChart"></canvas>
                </div>
            </div>
            
        </div>
    </div>
    @endif

    @if(in_array(session('admin_role', 'owner'), ['owner', 'admin_cs']))
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Orders -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Total Pesanan</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['total']) }}</h3>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Sedang Diproses</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['in_progress']) }}</h3>
            </div>
        </div>

        <!-- Wait Payment -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Menunggu Pelunasan</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['wait_payment']) }}</h3>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Selesai</p>
                <h3 class="text-2xl font-black text-gray-900">{{ number_format($stats['completed']) }}</h3>
            </div>
        </div>
    </div>

    <!-- Production Stage Breakdown -->
    <div class="mb-8">
        <h2 class="font-bold text-gray-900 mb-4">Rincian Tahap Produksi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Potong & Jahit -->
            <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex flex-col hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l-7-7m7 7l-2 2m2-2l2-2" /></svg>
                    </div>
                    <span class="text-2xl font-black text-gray-900">{{ number_format($productionBreakdown['potong_jahit']) }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-700 mb-2">Potong & Jahit</h3>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-auto">
                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $stats['in_progress'] > 0 ? ($productionBreakdown['potong_jahit'] / $stats['in_progress']) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Beli Bahan -->
            <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex flex-col hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                    </div>
                    <span class="text-2xl font-black text-gray-900">{{ number_format($productionBreakdown['sablon_bordir']) }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-700 mb-2">Beli Bahan</h3>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-auto">
                    <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ $stats['in_progress'] > 0 ? ($productionBreakdown['sablon_bordir'] / $stats['in_progress']) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Finishing & Packing -->
            <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex flex-col hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                    <span class="text-2xl font-black text-gray-900">{{ number_format($productionBreakdown['finishing']) }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-700 mb-2">Finishing & Packing</h3>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-auto">
                    <div class="bg-orange-500 h-1.5 rounded-full" style="width: {{ $stats['in_progress'] > 0 ? ($productionBreakdown['finishing'] / $stats['in_progress']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50/50">
            <h2 class="font-bold text-gray-900">Pesanan Terbaru</h2>
            <a href="{{ url('/admin/pesanan') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">Kode Tracking</th>
                        <th class="px-6 py-3">Pelanggan</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 font-mono text-xs font-semibold">
                                {{ $order->tracking_code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $order->customer_name }}</div>
                            @if($order->company_name)
                            <div class="text-xs text-gray-500">{{ $order->company_name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ $order->product_type }}</div>
                            <div class="text-xs text-gray-500">{{ number_format($order->quantity) }} Pcs • {{ $order->color }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $statusColors = [
                            'ORDER_MASUK' => 'bg-gray-100 text-gray-800',
                            'KIRIM' => 'bg-green-100 text-green-800',
                            'MENUNGGU_PELUNASAN' => 'bg-purple-100 text-purple-800',
                            ];
                            $colorClass = $statusColors[$order->current_status] ?? 'bg-blue-100 text-blue-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                {{ \App\Models\Order::$stageLabels[$order->current_status] ?? $order->current_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ url('/admin/pesanan/' . $order->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" title="Update Progres">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Belum ada data pesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Deadline Alert -->
    @if(count($deadlineOrders) > 0)
    <div class="bg-white rounded-2xl border border-red-200 shadow-sm overflow-hidden mt-8">
        <div class="px-6 py-4 border-b border-red-200 flex justify-between items-center bg-red-50/50">
            <h2 class="font-bold text-red-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Tenggat Waktu Terdekat (7 Hari)
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-white text-gray-500 font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3">Kode Tracking</th>
                        <th class="px-6 py-3">Pelanggan</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Estimasi Selesai</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($deadlineOrders as $order)
                    @php
                        $daysLeft = (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($order->estimated_finish)->startOfDay(), false);
                        $urgencyClass = $daysLeft <= 3 ? 'text-red-600 bg-red-50' : 'text-orange-600 bg-orange-50';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 font-mono text-xs font-semibold">
                                {{ $order->tracking_code }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $order->customer_name }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $order->product_type }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold {{ $urgencyClass }}">
                                {{ \Carbon\Carbon::parse($order->estimated_finish)->format('d M Y') }} 
                                ({{ $daysLeft < 0 ? 'Terlambat ' . abs($daysLeft) . ' hari' : $daysLeft . ' hari lagi' }})
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ url('/admin/pesanan/' . $order->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" title="Update Progres">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('omzetChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Omzet (Rp)',
                    data: chartData.omzet,
                    borderColor: '#10b981', // green-500
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    yAxisID: 'y',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Jumlah Order',
                    data: chartData.orders,
                    borderColor: '#3b82f6', // blue-500
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    yAxisID: 'y1',
                    type: 'bar'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.datasetIndex === 0) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.raw);
                            } else {
                                label += context.raw;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'Jt';
                            if (value >= 1000) return 'Rp ' + (value / 1000) + 'Rb';
                            return 'Rp ' + value;
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection