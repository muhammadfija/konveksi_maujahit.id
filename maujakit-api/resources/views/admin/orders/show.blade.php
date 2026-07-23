@extends('layouts.admin')

@section('title', 'Detail Pesanan - Admin MauJahit.id')

@section('content')
<div x-data="{ 
    showEditModal: {{ $errors->any() ? 'true' : 'false' }}, 
    deleteModal: false,
    updateStatusModal: false, 
    uploadPhotoModal: false,
    lightboxUrl: null
}">
    <div class="p-4 lg:p-6 animate-fade-in-up">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ url('/admin/pesanan') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                    {{ $order->tracking_code }}
                    @php
                        $statusColors = [
                            'ORDER_MASUK' => 'bg-gray-100 text-gray-800 border-gray-200',
                            'KIRIM' => 'bg-green-100 text-green-800 border-green-200',
                            'DP_PELUNASAN' => 'bg-purple-100 text-purple-800 border-purple-200',
                        ];
                        $colorClass = $statusColors[$order->current_status] ?? 'bg-blue-100 text-blue-800 border-blue-200';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                        {{ $stageLabels[$order->current_status] ?? $order->current_status }}
                    </span>
                    @if($order->is_priority)
                    <span class="px-3 py-1 rounded-full text-xs font-bold border border-red-200 bg-red-100 text-red-800 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        PRIORITAS
                    </span>
                    @endif
                </h1>
                <p class="text-sm text-gray-500">{{ $order->customer_name }} • Dibuat pada {{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            @if(in_array(session('admin_role', 'owner'), ['owner', 'admin_produksi', 'gudang']))
            <button @click="updateStatusModal = true" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 bg-[#1e3a6e] hover:bg-[#132848] text-white rounded-xl font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                Update Status
            </button>
            <button @click="uploadPhotoModal = true" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Upload Foto
            </button>
            @endif
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
            <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Progress Bar -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold text-gray-900">Total Progres Produksi</h3>
                    <span class="font-black text-[#1e3a6e]">{{ $order->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden border border-gray-200">
                    <div class="h-full bg-gradient-to-r from-[#1e3a6e] to-[#2e5090] rounded-full transition-all duration-1000 relative overflow-hidden" style="width: {{ $order->progress_percentage }}%;">
                        <div class="absolute inset-0 bg-white/20" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.1) 10px, rgba(255,255,255,0.1) 20px);"></div>
                    </div>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 relative">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900">Informasi Pesanan</h3>
                    <div class="flex gap-2">
                        @if(in_array(session('admin_role', 'owner'), ['owner', 'admin_cs']))
                        <button @click="showEditModal = true" class="text-sm font-medium text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg transition-colors">
                            Edit Data
                        </button>
                        @endif

                        @if(session('admin_role', 'owner') === 'owner')
                        <button @click="deleteModal = true" class="text-sm font-medium text-red-600 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                            Hapus
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Display Mode -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Pemesan</p>
                            <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Instansi / Perusahaan</p>
                            <p class="font-medium text-gray-900">{{ $order->company_name ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">WhatsApp</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->whatsapp) }}" target="_blank" class="inline-flex items-center gap-1 font-medium text-blue-600 hover:text-blue-800">
                                {{ $order->whatsapp }}
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Produk</p>
                            <p class="font-medium text-gray-900">{{ $order->product_type }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jumlah</p>
                                <p class="font-medium text-gray-900">{{ number_format($order->quantity) }} Pcs</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Warna</p>
                                <p class="font-medium text-gray-900">{{ $order->color }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Estimasi Selesai</p>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->estimated_finish)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">No. Resi</p>
                                <p class="font-medium text-gray-900">{{ $order->resi_number ?: '-' }}</p>
                            </div>
                        </div>
                        @if(in_array(session('admin_role', 'owner'), ['owner', 'keuangan']))
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Harga / Omzet</p>
                            <p class="font-medium text-green-600 font-bold">Rp {{ number_format((int)$order->total_price, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>

                    @if($order->notes)
                    <div class="md:col-span-2 mt-2 p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                        <p class="text-xs font-semibold text-yellow-800 uppercase tracking-wider mb-1">Catatan Tambahan</p>
                        <p class="text-sm text-yellow-900">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>



            </div>
        </div>

        <!-- Right Column: Timeline -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sticky top-20">
                <h3 class="font-bold text-gray-900 mb-5">Riwayat Progres</h3>
                
                <div class="space-y-1 relative">
                    @foreach($timeline as $index => $item)
                        @php
                            $lineColor = 'before:bg-gray-200';
                            if ($item['status'] === 'done') $lineColor = 'before:bg-green-400';
                            elseif ($item['status'] === 'current') $lineColor = 'before:bg-blue-400';
                            elseif ($item['status'] === 'late') $lineColor = 'before:bg-red-400';
                        @endphp
                        <div class="relative flex gap-4 pb-6 {{ $index !== count($timeline) - 1 ? 'before:absolute before:left-[11px] before:top-[28px] before:w-[2px] before:h-[calc(100%-10px)] ' . $lineColor : '' }}">
                            
                            <!-- Icon -->
                            <div class="flex-shrink-0 relative z-10 pt-1">
                                @if($item['status'] === 'done')
                                    <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center ring-4 ring-white shadow-sm">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                @elseif($item['status'] === 'current')
                                    <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center ring-4 ring-white shadow-sm">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                @elseif($item['status'] === 'late')
                                    <div class="w-6 h-6 rounded-full bg-red-500 flex items-center justify-center ring-4 ring-white shadow-sm">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 rounded-full bg-gray-50 border-2 border-gray-200 ring-4 ring-white flex items-center justify-center"></div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0 {{ $item['status'] === 'pending' ? 'opacity-50' : '' }}">
                                <div class="flex justify-between items-start mb-0.5">
                                    @php
                                        $textColor = 'text-gray-900';
                                        if ($item['status'] === 'done') $textColor = 'text-green-700';
                                        elseif ($item['status'] === 'current') $textColor = 'text-blue-700';
                                        elseif ($item['status'] === 'late') $textColor = 'text-red-700';
                                        elseif ($item['status'] === 'pending') $textColor = 'text-gray-500';
                                    @endphp
                                    <p class="text-sm font-bold {{ $textColor }}">
                                        {{ $item['label'] }}
                                    </p>
                                    @if($item['date'])
                                        <span class="text-[10px] text-gray-400 flex-shrink-0">{{ $item['date'] }}</span>
                                    @endif
                                </div>
                                
                                @if($item['note'])
                                    <p class="text-xs text-gray-500 mt-1">{{ $item['note'] }}</p>
                                @endif
                                
                                @if($item['photo_url'])
                                    <div class="mt-3">
                                        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm w-full max-w-[220px]">
                                            <img src="{{ $item['photo_url'] }}" alt="Foto Progres" class="w-full h-32 object-cover">
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Update Status -->
    <div x-show="updateStatusModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="updateStatusModal" x-transition.opacity class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="updateStatusModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="updateStatusModal" x-transition class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ url('/admin/pesanan/' . $order->id . '/status') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Update Status Produksi</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Status Baru</label>
                                        <select name="status" required class="block w-full border border-gray-300 rounded-lg py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-[#1e3a6e] focus:border-[#1e3a6e] sm:text-sm">
                                            @foreach($stages as $stage)
                                                @if(session('admin_role') === 'admin_produksi' && !in_array($stage, ['POTONG', 'JAHIT', 'QC']))
                                                    @continue
                                                @endif
                                                @if(session('admin_role') === 'gudang' && !in_array($stage, ['PACKING', 'KIRIM']))
                                                    @continue
                                                @endif
                                                <option value="{{ $stage }}" {{ $order->current_status === $stage ? 'selected' : '' }}>
                                                    {{ $stageLabels[$stage] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                                        <textarea name="note" rows="2" class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2" placeholder="Cth: Sedang proses jahit obras..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#1e3a6e] text-base font-medium text-white hover:bg-[#132848] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a6e] sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Update Status
                        </button>
                        <button type="button" @click="updateStatusModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a6e] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Upload Photo -->
    <div x-show="uploadPhotoModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="uploadPhotoModal" x-transition.opacity class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="uploadPhotoModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="uploadPhotoModal" x-transition class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ url('/admin/pesanan/' . $order->id . '/photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Upload Foto Bukti Pengerjaan</h3>
                                <p class="text-xs text-gray-500 mt-1">Foto ini akan muncul di timeline pelanggan saat mereka mengecek progres.</p>
                                
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Foto</label>
                                        <input type="file" name="photo" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Foto</label>
                                        <input type="text" name="note" class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border" placeholder="Cth: Hasil sablon bagian dada...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#1e3a6e] text-base font-medium text-white hover:bg-[#132848] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a6e] sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Upload Foto
                        </button>
                        <button type="button" @click="uploadPhotoModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a6e] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <!-- Edit Modal -->
    <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showEditModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showEditModal" x-transition class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ url('/admin/pesanan/' . $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Edit Pesanan</h3>
                                
                                @if ($errors->any())
                                    <div class="mt-2 p-3 rounded-xl bg-red-50 border border-red-200">
                                        <h3 class="font-bold text-red-800 text-xs mb-1">Terdapat Kesalahan Input</h3>
                                        <ul class="list-disc pl-4 text-[11px] text-red-600 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mt-4 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar pr-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemesan <span class="text-red-500">*</span></label>
                                        <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp <span class="text-red-500">*</span></label>
                                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $order->whatsapp) }}" required class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Instansi / Perusahaan</label>
                                        <input type="text" name="company_name" value="{{ old('company_name', $order->company_name) }}" class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                    </div>
                                    
                                    <div class="border-t border-gray-100 my-2"></div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk <span class="text-red-500">*</span></label>
                                        <input type="text" name="product_type" value="{{ old('product_type', $order->product_type) }}" required class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Warna <span class="text-red-500">*</span></label>
                                            <input type="text" name="color" value="{{ old('color', $order->color) }}" required class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                                            <input type="number" name="quantity" value="{{ old('quantity', $order->quantity) }}" required min="1" class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Selesai <span class="text-red-500">*</span></label>
                                        <input type="date" name="estimated_finish" value="{{ old('estimated_finish', substr($order->estimated_finish, 0, 10)) }}" required class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Resi Pengiriman</label>
                                        <input type="text" name="resi_number" value="{{ old('resi_number', $order->resi_number) }}" placeholder="Kosongkan jika belum ada" class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas Pesanan <span class="text-red-500">*</span></label>
                                        <div class="flex gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="is_priority" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('is_priority', $order->is_priority) == '0' ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 font-medium">Normal</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="is_priority" value="1" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" {{ old('is_priority', $order->is_priority) == '1' ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-red-600 font-medium flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                                    Prioritas
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    @if(in_array(session('admin_role', 'owner'), ['owner', 'keuangan']))
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Harga / Omzet (Rp)</label>
                                        <input type="number" name="total_price" value="{{ old('total_price', $order->total_price) }}" min="0" placeholder="0" class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">
                                    </div>
                                    @else
                                    <input type="hidden" name="total_price" value="{{ $order->total_price }}">
                                    @endif
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                                        <textarea name="notes" rows="2" class="shadow-sm focus:ring-[#1e3a6e] focus:border-[#1e3a6e] block w-full sm:text-sm border-gray-300 rounded-lg px-3 py-2 border">{{ old('notes', $order->notes) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#1e3a6e] text-base font-medium text-white hover:bg-[#132848] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a6e] sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Simpan Perubahan
                        </button>
                        <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a6e] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="deleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="deleteModal" x-transition.opacity class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="deleteModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="deleteModal" x-transition class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ url('/admin/pesanan/' . $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Hapus Pesanan</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus pesanan ini? Aksi ini tidak dapat dibatalkan dan semua data yang terkait akan terhapus permanen.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#dc2626] text-base font-medium text-white hover:bg-[#b91c1c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#dc2626] sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Ya, Hapus
                        </button>
                        <button type="button" @click="deleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a6e] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
