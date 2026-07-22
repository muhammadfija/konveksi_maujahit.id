'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import { ordersApi } from '@/lib/api';
import { Order, StatsResponse, OrdersResponse, STATUS_LABELS, ALL_STAGES, ProductionStatus } from '@/lib/types';

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

const DOT_COLORS: Record<string, string> = {
  JAHIT: 'bg-emerald-500',
  QC: 'bg-violet-500',
  PACKING: 'bg-pink-500',
  KIRIM: 'bg-green-500',
  DEFAULT: 'bg-blue-500',
};

function StatCard({ label, value, subtitle, icon, color }: { label: string; value: number; subtitle: string; icon: React.ReactNode; color: string }) {
  return (
    <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center justify-between hover:shadow-md transition-shadow">
      <div>
        <p className="text-xs text-gray-500 font-medium mb-1">{label}</p>
        <p className="text-3xl font-black text-gray-900 mb-0.5">{value.toLocaleString('id-ID')}</p>
        <p className="text-xs text-gray-400">{subtitle}</p>
      </div>
      <div className={`w-14 h-14 ${color} rounded-2xl flex items-center justify-center opacity-80`}>
        {icon}
      </div>
    </div>
  );
}

export default function DashboardPage() {
  const [adminName, setAdminName] = useState('Admin MauJahit');
  const [stats, setStats] = useState({ total: 0, in_progress: 0, completed: 0, wait_payment: 0 });
  const [orders, setOrders] = useState<Order[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchInput, setSearchInput] = useState('');
  const [debouncedSearch, setDebouncedSearch] = useState('');
  const [statusFilter, setStatusFilter] = useState('');

  useEffect(() => {
    const timer = setTimeout(() => {
      if (debouncedSearch !== searchInput) {
        setDebouncedSearch(searchInput);
      }
    }, 500);
    return () => clearTimeout(timer);
  }, [searchInput, debouncedSearch]);

  useEffect(() => {
    const name = localStorage.getItem('admin_name');
    if (name) setAdminName(name);
  }, []);

  useEffect(() => {
    fetchData();
  }, [debouncedSearch, statusFilter]);

  const fetchData = async () => {
    setLoading(true);
    try {
      const [statsRes, ordersRes] = await Promise.all([
        ordersApi.stats() as Promise<StatsResponse>,
        ordersApi.list({ 
          per_page: 5,
          search: debouncedSearch || undefined,
          status: statusFilter || undefined,
        }) as Promise<OrdersResponse>,
      ]);
      setStats(statsRes.data);
      setOrders(ordersRes.data.data);
    } catch (e) {
      console.error(e);
    } finally {
      setLoading(false);
    }
  };

  const currentStageIndex = () => 6; // "Sedang Jahit" index in ALL_STAGES for demo timeline

  return (
    <div className="p-4 lg:p-6">
      {/* Welcome */}
      <div className="mb-6">
        <h1 className="text-xl font-black text-gray-900">
          Selamat datang, {adminName} 👋
        </h1>
        <p className="text-gray-500 text-sm mt-1">Kelola pesanan dan pantau setiap proses produksi dengan mudah.</p>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <StatCard
          label="Total Pesanan"
          value={stats.total}
          subtitle="Semua Pesanan"
          color="bg-blue-50"
          icon={
            <svg className="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          }
        />
        <StatCard
          label="Dalam Proses"
          value={stats.in_progress}
          subtitle="Sedang Dikerjakan"
          color="bg-emerald-50"
          icon={
            <svg className="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
            </svg>
          }
        />
        <StatCard
          label="Selesai"
          value={stats.completed}
          subtitle="Selesai Produksi"
          color="bg-yellow-50"
          icon={
            <svg className="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          }
        />
        <StatCard
          label="Menunggu Pelunasan"
          value={stats.wait_payment}
          subtitle="Menunggu Pembayaran"
          color="bg-purple-50"
          icon={
            <svg className="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
            </svg>
          }
        />
      </div>

      {/* Orders Table */}
      <div className="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-5 border-b border-gray-100">
          <h2 className="font-black text-gray-900 text-base">Daftar Pesanan Terbaru</h2>
          <div className="flex items-center gap-2">
            <div className="relative">
              <svg className="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <input
                type="text"
                value={searchInput}
                onChange={(e) => setSearchInput(e.target.value)}
                placeholder="Cari kode tracking / nama pelanggan..."
                className="text-xs border border-gray-200 rounded-lg pl-9 pr-3 py-2 w-56 focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/20"
              />
            </div>
            <select 
              value={statusFilter}
              onChange={(e) => setStatusFilter(e.target.value)}
              className="text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/20"
            >
              <option value="">Filter Status</option>
              {ALL_STAGES.map(s => <option key={s} value={s}>{STATUS_LABELS[s]}</option>)}
            </select>
            <Link
              href="/admin/pesanan/baru"
              className="flex items-center gap-1.5 bg-[#1e3a6e] hover:bg-[#132848] text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors whitespace-nowrap"
            >
              <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M12 4v16m8-8H4" />
              </svg>
              Tambah Pesanan
            </Link>
          </div>
        </div>

        {loading ? (
          <div className="flex justify-center py-16">
            <div className="w-8 h-8 border-3 border-gray-200 border-t-[#1e3a6e] rounded-full spinner" />
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="bg-gray-50 text-left">
                  {['KODE TRACKING', 'NAMA PELANGGAN', 'PRODUK', 'TANGGAL PESAN', 'ESTIMASI SELESAI', 'STATUS', 'AKSI'].map(h => (
                    <th key={h} className="px-4 py-3 text-xs font-bold text-gray-500 tracking-wider">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-50">
                {orders.map((order) => {
                  const dotColor = DOT_COLORS[order.current_status] || DOT_COLORS.DEFAULT;
                  const badgeColor = STATUS_COLORS[order.current_status] || 'bg-gray-100 text-gray-700';
                  return (
                    <tr key={order.id} className="hover:bg-gray-50 transition-colors">
                      <td className="px-4 py-3.5">
                        <div className="flex items-center gap-2">
                          <div className={`w-2 h-2 rounded-full ${dotColor} flex-shrink-0`} />
                          <span className="font-bold text-[#1e3a6e] font-mono text-xs">{order.tracking_code}</span>
                        </div>
                      </td>
                      <td className="px-4 py-3.5">
                        <span className="font-medium text-gray-800">{order.company_name || order.customer_name}</span>
                      </td>
                      <td className="px-4 py-3.5">
                        <div className="font-medium text-gray-800">{order.product_type}</div>
                        <div className="text-xs text-gray-400">{order.quantity.toLocaleString('id-ID')} Pcs</div>
                      </td>
                      <td className="px-4 py-3.5 text-gray-600">{order.created_at}</td>
                      <td className="px-4 py-3.5 text-gray-600">{order.estimated_finish}</td>
                      <td className="px-4 py-3.5">
                        <div className="flex items-center gap-2">
                          <span className={`text-[11px] font-semibold px-2.5 py-1 rounded-full ${badgeColor} whitespace-nowrap`}>
                            {order.current_status_label}
                          </span>
                          <span className="text-xs text-gray-400">{order.progress_percentage}%</span>
                        </div>
                      </td>
                      <td className="px-4 py-3.5">
                        <div className="flex items-center gap-1.5">
                          <Link
                            href={`/admin/pesanan/${order.id}`}
                            className="p-1.5 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-[#1e3a6e] transition-colors"
                            title="Edit"
                          >
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                          </Link>
                          <button className="p-1.5 hover:bg-gray-100 rounded-lg text-gray-400 hover:text-gray-600 transition-colors">
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                  );
                })}
                {orders.length === 0 && (
                  <tr>
                    <td colSpan={7} className="py-12 text-center text-gray-400 text-sm">
                      Belum ada pesanan. <Link href="/admin/pesanan/baru" className="text-[#1e3a6e] font-semibold">Tambah pesanan pertama</Link>
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        )}

        {orders.length > 0 && (
          <div className="flex items-center justify-between px-5 py-3.5 border-t border-gray-100 text-xs text-gray-500">
            <span>Menampilkan 1 - {orders.length} dari {stats.total} data</span>
            <div className="flex items-center gap-1">
              <button className="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center hover:border-[#1e3a6e] transition-colors">
                <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" /></svg>
              </button>
              <button className="w-7 h-7 rounded-lg bg-[#1e3a6e] text-white text-xs font-bold">1</button>
              <button className="w-7 h-7 rounded-lg border border-gray-200 text-xs hover:border-[#1e3a6e] transition-colors">2</button>
              <button className="w-7 h-7 rounded-lg border border-gray-200 text-xs hover:border-[#1e3a6e] transition-colors">3</button>
              <span className="px-1">...</span>
              <button className="w-7 h-7 rounded-lg border border-gray-200 text-xs hover:border-[#1e3a6e] transition-colors">
                <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" /></svg>
              </button>
            </div>
          </div>
        )}
      </div>

      {/* Production Stage Summary */}
      <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h2 className="font-black text-gray-900 text-base mb-5">Ringkasan Proses Produksi</h2>
        <div className="flex items-start gap-0 overflow-x-auto pb-2">
          {ALL_STAGES.map((stage, index) => {
            const isDone = index < 5;
            const isCurrent = index === 5;
            return (
              <div key={stage} className="flex flex-col items-center gap-2 min-w-[70px]">
                <div className="flex items-center w-full">
                  <div className={`w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mx-auto border-2 ${
                    isDone ? 'bg-[#1e3a6e] border-[#1e3a6e]' :
                    isCurrent ? 'bg-[#1e3a6e] border-[#1e3a6e] ring-4 ring-blue-100' :
                    'bg-white border-gray-200'
                  }`}>
                    {isDone ? (
                      <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                      </svg>
                    ) : isCurrent ? (
                      <svg viewBox="0 0 24 24" fill="none" className="w-4 h-4 text-white" stroke="currentColor" strokeWidth="1.5">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                      </svg>
                    ) : (
                      <svg className="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    )}
                  </div>
                </div>
                <span className={`text-[9px] text-center leading-tight font-medium ${
                  isDone || isCurrent ? 'text-gray-700' : 'text-gray-300'
                }`}>
                  {STATUS_LABELS[stage]}
                </span>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
}
