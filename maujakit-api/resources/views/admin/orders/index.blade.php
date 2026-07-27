@extends('layouts.admin')

@section('title', 'Daftar Pesanan - Admin MauJahit.id')

@section('content')
<div x-data="{ deleteModal: false, deleteUrl: '' }" class="p-4 lg:p-6 animate-fade-in-up relative">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Daftar Pesanan</h1>
            <p class="text-sm text-gray-500">Kelola semua pesanan produksi dari pelanggan.</p>
        </div>
        @if(in_array(session('admin_role', 'owner'), ['owner', 'admin_cs']))
        <a href="{{ url('/admin/pesanan/baru') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#1e3a6e] hover:bg-[#132848] text-white rounded-xl font-medium transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pesanan
        </a>
        @endif
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 mb-6">
        <form action="{{ url('/admin/pesanan') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. tracking, nama, atau instansi..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl focus:ring-[#1e3a6e] focus:border-[#1e3a6e] text-sm">
                </div>
            </div>
            <div class="w-full sm:w-48">
                <select name="status" class="block w-full border border-gray-200 rounded-xl py-2 px-3 focus:ring-[#1e3a6e] focus:border-[#1e3a6e] text-sm text-gray-700" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    @foreach($stages as $stage)
                    <option value="{{ $stage }}" {{ request('status') === $stage ? 'selected' : '' }}>
                        {{ $stageLabels[$stage] }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium text-sm transition-colors">
                    Filter
                </button>
            </div>
            @if(request('search') || request('status'))
            <div class="w-full sm:w-auto">
                <a href="{{ url('/admin/pesanan') }}" class="block w-full sm:w-auto px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-medium text-sm transition-colors text-center">
                    Reset
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-4">Kode Tracking</th>
                        <th class="px-4 py-4">Pelanggan</th>
                        <th class="px-4 py-4 hidden md:table-cell">Produk</th>
                        <th class="px-4 py-4 hidden lg:table-cell">Estimasi Selesai</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 text-gray-800 font-mono text-xs font-semibold">
                                {{ $order->tracking_code }}
                                @if($order->is_priority)
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-medium text-gray-900">{{ $order->customer_name }}</div>
                            @if($order->company_name)
                            <div class="text-xs text-gray-500">{{ $order->company_name }}</div>
                            @endif
                            <div class="text-xs text-gray-400 flex items-center gap-1 mt-1 md:hidden">
                                <span class="font-medium text-gray-600">{{ $order->product_type }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 hidden md:table-cell">
                            <div class="text-gray-900">{{ $order->product_type }}</div>
                            <div class="text-xs text-gray-500">{{ number_format($order->quantity) }} Pcs • {{ $order->color }}</div>
                        </td>
                        <td class="px-4 py-4 hidden lg:table-cell">
                            <div class="text-gray-900">{{ \Carbon\Carbon::parse($order->estimated_finish)->format('d M Y') }}</div>
                        </td>
                        <td class="px-4 py-4">
                            @php
                            $statusColors = [
                            'ORDER_MASUK' => 'bg-gray-100 text-gray-800',
                            'KIRIM' => 'bg-green-100 text-green-800',
                            'MENUNGGU_PELUNASAN' => 'bg-purple-100 text-purple-800',
                            ];
                            $colorClass = $statusColors[$order->current_status] ?? 'bg-blue-100 text-blue-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                {{ $stageLabels[$order->current_status] ?? $order->current_status }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ url('/admin/pesanan/' . $order->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" title="Update Progres & Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                @if(in_array(session('admin_role', 'owner'), ['owner', 'admin_cs']))
                                <button type="button" @click="deleteUrl = '{{ url('/admin/pesanan/' . $order->id) }}'; deleteModal = true" class="inline-flex items-center justify-center p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors" title="Hapus Pesanan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada pesanan ditemukan</h3>
                            <p class="text-gray-500">Coba ubah filter pencarian Anda atau tambah pesanan baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
        @endif
    </div>


    <!-- Delete Modal -->

    <div x-show="deleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="deleteModal" x-transition.opacity class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="deleteModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="deleteModal" x-transition class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form :action="deleteUrl" method="POST">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const form = searchInput.closest('form');
    let timeout = null;

    // Optional: Maintain focus if there's a search value
    if (searchInput.value) {
        searchInput.focus();
        // Move cursor to the end
        const val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            // Show loading state on form or body if desired
            form.submit();
        }, 500);
    });
});
</script>
@endsection