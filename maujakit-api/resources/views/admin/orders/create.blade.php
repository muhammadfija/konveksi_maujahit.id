@extends('layouts.admin')

@section('title', 'Tambah Pesanan - Admin MauJahit.id')

@section('content')
<div class="p-4 lg:p-6 animate-fade-in-up">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ url('/admin/pesanan') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h1 class="text-2xl font-black text-gray-900">Tambah Pesanan Baru</h1>
            <p class="text-sm text-gray-500">Isi form berikut untuk membuat pesanan produksi baru.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
            <h3 class="font-bold text-red-800 mb-1">Terdapat Kesalahan Input</h3>
            <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/pesanan') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column: Form Fields --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Data Pelanggan --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-black">1</span>
                        Data Pelanggan
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan <span class="text-red-500">*</span></label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                                placeholder="Contoh: Budi Santoso"
                                class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required
                                placeholder="Contoh: 081234567890"
                                class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instansi / Perusahaan</label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}"
                                placeholder="Contoh: PT Sukses Makmur (opsional)"
                                class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">
                        </div>
                    </div>
                </div>

                {{-- Detail Produksi --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6" x-data="{ customProduct: '{{ old('product_type') == 'Lainnya' ? '1' : '0' }}' }">
                    <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-black">2</span>
                        Detail Produksi
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk <span class="text-red-500">*</span></label>
                            <select name="product_type" required
                                class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e] appearance-none bg-white"
                                @change="customProduct = $event.target.value === 'Lainnya' ? '1' : '0'">
                                <option value="" disabled selected>Pilih jenis produk...</option>
                                <option value="Kaos Oblong (T-Shirt)" {{ old('product_type') == 'Kaos Oblong (T-Shirt)' ? 'selected' : '' }}>Kaos Oblong (T-Shirt)</option>
                                <option value="Kemeja Korsa / PDL" {{ old('product_type') == 'Kemeja Korsa / PDL' ? 'selected' : '' }}>Kemeja Korsa / PDL</option>
                                <option value="Jaket Hoodie" {{ old('product_type') == 'Jaket Hoodie' ? 'selected' : '' }}>Jaket Hoodie</option>
                                <option value="Jaket Bomber" {{ old('product_type') == 'Jaket Bomber' ? 'selected' : '' }}>Jaket Bomber</option>
                                <option value="Polo Shirt" {{ old('product_type') == 'Polo Shirt' ? 'selected' : '' }}>Polo Shirt</option>
                                <option value="Jaket Varsity" {{ old('product_type') == 'Jaket Varsity' ? 'selected' : '' }}>Jaket Varsity</option>
                                <option value="Lainnya" {{ old('product_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div x-show="customProduct === '1'" style="display: none;" class="mt-2" x-transition>
                                <input type="text" name="custom_product_type" value="{{ old('custom_product_type') }}"
                                    placeholder="Tuliskan jenis produk lainnya..."
                                    class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]"
                                    :required="customProduct === '1'">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Warna <span class="text-red-500">*</span></label>
                                <input type="text" name="color" value="{{ old('color') }}" required
                                    placeholder="Contoh: Hitam, Navy"
                                    class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Pcs) <span class="text-red-500">*</span></label>
                                <input type="number" name="quantity" value="{{ old('quantity') }}" required min="1"
                                    placeholder="100"
                                    class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                            <textarea name="notes" rows="3"
                                placeholder="Catatan spesial, bahan, ukuran, atau detail tambahan pesanan..."
                                class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column --}}
            <div class="space-y-6">

                {{-- Target & Harga --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-black">3</span>
                        Target & Keuangan
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Selesai <span class="text-red-500">*</span></label>
                            <input type="date" name="estimated_finish" value="{{ old('estimated_finish') }}" required
                                class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">
                        </div>
                        @if(in_array(session('admin_role', 'owner'), ['owner', 'admin_cs', 'keuangan']))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Harga / Omzet</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm font-medium">Rp</span>
                                </div>
                                <input type="number" name="total_price" value="{{ old('total_price') }}" min="0"
                                    placeholder="0"
                                    class="pl-10 block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-[#1e3a6e]">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Prioritas --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs font-black">4</span>
                        Prioritas Pesanan
                    </h3>
                    <div class="grid grid-cols-2 gap-3" x-data>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-colors has-[:checked]:bg-blue-50 has-[:checked]:border-blue-300 has-[:checked]:ring-1 has-[:checked]:ring-blue-400">
                            <input type="radio" name="is_priority" value="0" class="w-4 h-4 text-blue-600" {{ old('is_priority', '0') == '0' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Normal</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-red-50 hover:border-red-300 transition-colors has-[:checked]:bg-red-50 has-[:checked]:border-red-300 has-[:checked]:ring-1 has-[:checked]:ring-red-400">
                            <input type="radio" name="is_priority" value="1" class="w-4 h-4 text-red-600" {{ old('is_priority') == '1' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Prioritas
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-3">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-[#1e3a6e] hover:bg-[#132848] text-white font-bold rounded-xl transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pesanan
                    </button>
                    <a href="{{ url('/admin/pesanan') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                        Batal
                    </a>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
