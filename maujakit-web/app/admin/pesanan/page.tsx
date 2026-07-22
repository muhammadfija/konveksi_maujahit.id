'use client';

import { useEffect, useState, useCallback } from 'react';
import Link from 'next/link';
import { ordersApi } from '@/lib/api';
import { Order, OrdersResponse, STATUS_LABELS, ALL_STAGES, ProductionStatus } from '@/lib/types';

const STATUS_COLORS: Record<string, string> = {
  ORDER_MASUK: 'bg-gray-100 text-gray-700',
  DP_PELUNASAN: 'bg-blue-100 text-blue-700',
  DESAIN: 'bg-purple-100 text-purple-700',
  BELI_BAHAN: 'bg-amber-100 text-amber-700',
  POTONG: 'bg-yellow-100 text-yellow-700',
  JAHIT: 'bg-emerald-100 text-emerald-700',
  QC: 'bg-violet-100 text-violet-700',
  PACKING: 'bg-pink-100 text-pink-700',
  KIRIM: 'bg-green-100 text-green-800',
};

export default function PesananPage() {
  const [orders, setOrders] = useState<Order[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchInput, setSearchInput] = useState('');
  const [debouncedSearch, setDebouncedSearch] = useState('');
  const [statusFilter, setStatusFilter] = useState('');
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);
  const [total, setTotal] = useState(0);

  useEffect(() => {
    const timer = setTimeout(() => {
      if (debouncedSearch !== searchInput) {
        setDebouncedSearch(searchInput);
        setCurrentPage(1);
      }
    }, 500);
    return () => clearTimeout(timer);
  }, [searchInput, debouncedSearch]);

  const fetchOrders = useCallback(async () => {
    setLoading(true);
    try {
      const res = await ordersApi.list({
        page: currentPage,
        search: debouncedSearch || undefined,
        status: statusFilter || undefined,
        per_page: 5,
      }) as OrdersResponse;
      setOrders(res.data.data);
      setTotalPages(res.data.last_page);
      setTotal(res.data.total);
    } catch (e) {
      console.error(e);
    } finally {
      setLoading(false);
    }
  }, [currentPage, debouncedSearch, statusFilter]);

  useEffect(() => {
    fetchOrders();
  }, [fetchOrders]);

  const handleDelete = async (id: number, code: string) => {
    if (!confirm(`Hapus pesanan ${code}?`)) return;
    try {
      await ordersApi.delete(id);
      fetchOrders();
    } catch (e) {
      alert('Gagal menghapus pesanan.');
    }
  };

  return (
    <div className="p-4 lg:p-6">
      <div className="flex items-center justify-between mb-6">
        <div>
          <h1 className="text-xl font-black text-gray-900">Daftar Pesanan</h1>
          <p className="text-gray-500 text-sm mt-1">Kelola semua pesanan produksi pakaian</p>
        </div>
        <Link
          href="/admin/pesanan/baru"
          className="flex items-center gap-2 bg-[#1e3a6e] hover:bg-[#132848] text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-colors"
        >
          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M12 4v16m8-8H4" />
          </svg>
          Tambah Pesanan
        </Link>
      </div>

      <div className="bg-white rounded-2xl border border-gray-100 shadow-sm">
        {/* Filters */}
        <div className="flex flex-col sm:flex-row gap-3 p-4 border-b border-gray-100">
          <div className="relative flex-1">
            <svg className="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
              type="text"
              placeholder="Cari kode tracking / nama pelanggan..."
              value={searchInput}
              onChange={(e) => setSearchInput(e.target.value)}
              className="w-full border border-gray-200 rounded-xl pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/20"
            />
          </div>
          <select
            value={statusFilter}
            onChange={(e) => { setStatusFilter(e.target.value); setCurrentPage(1); }}
            className="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/20 bg-white min-w-[160px]"
          >
            <option value="">Semua Status</option>
            {ALL_STAGES.map(s => <option key={s} value={s}>{STATUS_LABELS[s]}</option>)}
          </select>
        </div>

        {/* Table */}
        {loading ? (
          <div className="flex justify-center py-16">
            <div className="w-8 h-8 border-2 border-gray-200 border-t-[#1e3a6e] rounded-full spinner" />
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left">
                  {['KODE TRACKING', 'PELANGGAN', 'PRODUK', 'TGL PESAN', 'EST. SELESAI', 'STATUS', 'AKSI'].map(h => (
                    <th key={h} className="px-4 py-3 text-xs font-bold text-gray-500 tracking-wider whitespace-nowrap">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-50">
                {orders.map((order) => (
                  <tr key={order.id} className="hover:bg-gray-50 transition-colors group">
                    <td className="px-4 py-3.5">
                      <span className="font-bold text-[#1e3a6e] font-mono text-xs">{order.tracking_code}</span>
                    </td>
                    <td className="px-4 py-3.5">
                      <div className="font-medium text-gray-800">{order.company_name || order.customer_name}</div>
                      <div className="text-xs text-gray-400">{order.whatsapp}</div>
                    </td>
                    <td className="px-4 py-3.5">
                      <div className="font-medium text-gray-800">{order.product_type}</div>
                      <div className="text-xs text-gray-400">{order.quantity.toLocaleString()} Pcs · {order.color}</div>
                    </td>
                    <td className="px-4 py-3.5 text-gray-600 whitespace-nowrap">{order.created_at}</td>
                    <td className="px-4 py-3.5 text-gray-600 whitespace-nowrap">{order.estimated_finish}</td>
                    <td className="px-4 py-3.5">
                      <div className="flex items-center gap-2">
                        <span className={`text-[11px] font-semibold px-2.5 py-1 rounded-full ${STATUS_COLORS[order.current_status] || 'bg-gray-100 text-gray-700'} whitespace-nowrap`}>
                          {order.current_status_label}
                        </span>
                        <span className="text-xs text-gray-400">{order.progress_percentage}%</span>
                      </div>
                    </td>
                    <td className="px-4 py-3.5">
                      <div className="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <Link
                          href={`/admin/pesanan/${order.id}`}
                          className="p-1.5 hover:bg-blue-50 rounded-lg text-gray-400 hover:text-[#1e3a6e] transition-colors"
                          title="Detail & Edit"
                        >
                          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                          </svg>
                        </Link>
                        <button
                          onClick={() => handleDelete(order.id, order.tracking_code)}
                          className="p-1.5 hover:bg-red-50 rounded-lg text-gray-400 hover:text-red-500 transition-colors"
                          title="Hapus"
                        >
                          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
                {orders.length === 0 && (
                  <tr>
                    <td colSpan={7} className="py-16 text-center">
                      <div className="text-4xl mb-3">📭</div>
                      <p className="text-gray-400 text-sm">
                        {searchInput || statusFilter ? 'Tidak ada pesanan yang cocok.' : 'Belum ada pesanan.'}{' '}
                        {!searchInput && !statusFilter && (
                          <Link href="/admin/pesanan/baru" className="text-[#1e3a6e] font-semibold">Tambah sekarang</Link>
                        )}
                      </p>
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        )}

        {/* Pagination */}
        {orders.length > 0 && (
          <div className="flex items-center justify-between px-4 py-3.5 border-t border-gray-100 text-xs text-gray-500">
            <span>Total {total.toLocaleString()} pesanan</span>
            <div className="flex items-center gap-1">
              <button
                onClick={() => setCurrentPage(p => Math.max(1, p - 1))}
                disabled={currentPage === 1}
                className="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center hover:border-[#1e3a6e] disabled:opacity-40"
              >
                <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" /></svg>
              </button>
              {Array.from({ length: Math.min(5, totalPages) }, (_, i) => i + 1).map(page => (
                <button
                  key={page}
                  onClick={() => setCurrentPage(page)}
                  className={`w-7 h-7 rounded-lg border text-xs transition-colors ${currentPage === page ? 'bg-[#1e3a6e] text-white border-[#1e3a6e]' : 'border-gray-200 hover:border-[#1e3a6e]'}`}
                >
                  {page}
                </button>
              ))}
              <button
                onClick={() => setCurrentPage(p => Math.min(totalPages, p + 1))}
                disabled={currentPage === totalPages}
                className="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center hover:border-[#1e3a6e] disabled:opacity-40"
              >
                <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" /></svg>
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
