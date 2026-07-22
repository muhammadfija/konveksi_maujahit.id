@extends('layouts.admin')

@section('title', 'Tambah Pesanan Baru - Admin MauJahit.id')

@section('content')
<div class="p-4 lg:p-8 animate-fade-in-up w-full">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-black text-gray-900">Tambah Pesanan Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Lengkapi form di bawah ini. Kode tracking akan di-generate otomatis.</p>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-5 rounded-2xl bg-red-50 border border-red-200 flex items-start gap-4">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <h3 class="font-bold text-red-800 mb-1">Terdapat Kesalahan Input</h3>
                <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ url('/admin/pesanan') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column -->
            <div class="lg:col-span-2">
                <!-- Data Pelanggan -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm border-t-4 border-t-blue-500 mb-8">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-[#1e3a6e]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">Data Pelanggan</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pelanggan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Contoh: Budi Santoso" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">No. WhatsApp <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    </div>
                                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="Contoh: 081234567890" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Instansi / Perusahaan (Opsional)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                    <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Contoh: PT Sukses Makmur" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Produksi -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm border-t-4 border-t-purple-500 mb-8">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">Detail Produksi</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ customProduct: '{{ old('product_type') == 'Lainnya' ? '1' : '0' }}' }">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Produk <span class="text-red-500">*</span></label>
                                <select name="product_type" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all appearance-none cursor-pointer" @change="customProduct = $event.target.value === 'Lainnya' ? '1' : '0'">
                                    <option value="" disabled selected>Pilih jenis produk...</option>
                                    <option value="Kaos Oblong (T-Shirt)" {{ old('product_type') == 'Kaos Oblong (T-Shirt)' ? 'selected' : '' }}>Kaos Oblong (T-Shirt)</option>
                                    <option value="Kemeja Korsa / PDL" {{ old('product_type') == 'Kemeja Korsa / PDL' ? 'selected' : '' }}>Kemeja Korsa / PDL</option>
                                    <option value="Jaket Hoodie" {{ old('product_type') == 'Jaket Hoodie' ? 'selected' : '' }}>Jaket Hoodie</option>
                                    <option value="Jaket Bomber" {{ old('product_type') == 'Jaket Bomber' ? 'selected' : '' }}>Jaket Bomber</option>
                                    <option value="Polo Shirt" {{ old('product_type') == 'Polo Shirt' ? 'selected' : '' }}>Polo Shirt</option>
                                    <option value="Lainnya" {{ old('product_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                <div x-show="customProduct === '1'" style="display: none;" class="mt-3" x-transition>
                                    <input type="text" name="custom_product_type" value="{{ old('custom_product_type') }}" placeholder="Tuliskan jenis produk lainnya..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all" :required="customProduct === '1'">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Warna <span class="text-red-500">*</span></label>
                                <input type="text" name="color" value="{{ old('color') }}" required placeholder="Contoh: Hitam / Navy Blue" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah (Pcs) <span class="text-red-500">*</span></label>
                                <input type="number" name="quantity" value="{{ old('quantity') }}" required min="1" placeholder="Contoh: 100" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Total Harga / Omzet</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="total_price" value="{{ old('total_price') }}" min="0" placeholder="0" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all">
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" rows="4" placeholder="Contoh: Sablon plastisol dada kiri 8cm, belakang A3." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Timeline & Actions -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden sticky top-24">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Prioritas Pesanan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <label class="cursor-pointer">
                                <input type="radio" name="is_priority" value="0" class="peer sr-only" checked>
                                <div class="rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all text-center">
                                    Normal
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="is_priority" value="1" class="peer sr-only" {{ old('is_priority') == '1' ? 'checked' : '' }}>
                                <div class="rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition-all text-center flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    Prioritas
                                </div>
                            </label>
                        </div>

                        <label class="block text-sm font-semibold text-gray-700 mb-3">Tenggat Waktu <span class="text-red-500">*</span></label>
                        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                            <div class="flex items-center gap-3 mb-2 text-sm font-medium text-gray-600">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Estimasi Selesai
                            </div>
                            <input type="date" name="estimated_finish" value="{{ old('estimated_finish') }}" required class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] transition-all text-gray-900 font-semibold">
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <button type="submit" class="w-full py-3.5 rounded-xl font-bold bg-[#1e3a6e] hover:bg-[#132848] text-white transition-all shadow-md shadow-blue-900/20 flex items-center justify-center gap-2 group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                            Simpan Pesanan Baru
                        </button>
                        <a href="{{ url('/admin/pesanan') }}" class="w-full py-3.5 rounded-xl font-semibold bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors flex items-center justify-center">
                            Batal
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

