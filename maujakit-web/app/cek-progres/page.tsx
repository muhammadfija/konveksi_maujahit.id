'use client';

import { useState } from 'react';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';
import ProductionTimeline from '@/components/ProductionTimeline';
import { trackingApi } from '@/lib/api';
import { Order } from '@/lib/types';

export default function CekProgresPage() {
  const [code, setCode] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [order, setOrder] = useState<Order | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const trimmed = code.trim().toUpperCase();
    if (!trimmed) return;

    setLoading(true);
    setError('');
    setOrder(null);

    try {
      const res = await trackingApi.check(trimmed) as { success: boolean; data: Order; message?: string };
      if (res.success) {
        setOrder(res.data);
      } else {
        setError(res.message || 'Kode tracking tidak ditemukan.');
      }
    } catch (err: unknown) {
      const msg = err instanceof Error ? err.message : 'Terjadi kesalahan.';
      setError(msg.includes('404') || msg.includes('ditemukan') ? 'Kode tracking tidak ditemukan. Periksa kembali kode Anda.' : 'Tidak dapat terhubung ke server. Coba lagi nanti.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen flex flex-col bg-gray-50">
      <Navbar />

      {/* Hero & Search */}
      <section className="relative bg-[#0d1f3c] text-white overflow-hidden">
        <div className="absolute inset-0">
          <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMyMDQwNzAiIGZpbGwtb3BhY2l0eT0iMC4xNSI+PHBhdGggZD0iTTM2IDM0djZoNnYtNmgtNnptMCAwdjZoNnYtNmg2em0tNiAwdjZoNnYtNmgtNnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40" />
          <div className="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl" />
          <div className="absolute bottom-0 left-0 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl" />
        </div>
        <div className="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
          <div className="text-center mb-10">
            <h1 className="text-4xl lg:text-5xl font-black mb-4 leading-tight">
              Cek Progres Pesanan Anda
            </h1>
            <p className="text-white/70 text-lg max-w-xl mx-auto">
              Pantau setiap tahap produksi pesanan Anda secara real-time dan transparan.
            </p>
          </div>

          {/* Search Box */}
          <div className="bg-white rounded-2xl p-8 shadow-2xl max-w-2xl mx-auto">
            <div className="flex items-center gap-3 mb-2">
              <div className="w-10 h-10 bg-[#1e3a6e] rounded-xl flex items-center justify-center">
                <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <div>
                <h2 className="text-lg font-bold text-gray-900">Masukkan Kode Tracking</h2>
                <p className="text-xs text-gray-400">Masukkan kode tracking yang telah diberikan oleh admin kami.</p>
              </div>
            </div>

            <form onSubmit={handleSubmit} className="mt-5">
              <input
                id="tracking-code-input"
                type="text"
                value={code}
                onChange={(e) => setCode(e.target.value.toUpperCase())}
                placeholder="Contoh: MJK-9X2L7Q"
                className="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-gray-800 text-base font-medium focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent placeholder:text-gray-300 tracking-wider"
                autoComplete="off"
              />
              <button
                id="cek-progres-btn"
                type="submit"
                disabled={loading || !code.trim()}
                className="w-full mt-3 bg-[#1e3a6e] hover:bg-[#132848] disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-base"
              >
                {loading ? (
                  <>
                    <div className="w-5 h-5 border-2 border-white/30 border-t-white rounded-full spinner" />
                    Memverifikasi...
                  </>
                ) : (
                  <>
                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cek Progres
                  </>
                )}
              </button>
            </form>

            <div className="mt-4 flex items-center gap-2 justify-center text-xs text-gray-400">
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              Data pesanan Anda aman dan hanya dapat diakses dengan kode tracking.
            </div>
          </div>
        </div>
      </section>

      {/* Result */}
      <div className="max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
        {/* Error */}
        {error && (
          <div id="tracking-error" className="bg-red-50 border border-red-200 rounded-2xl p-6 mb-6 flex items-start gap-4 animate-fade-in-up">
            <div className="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
              <svg className="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div>
              <h3 className="font-bold text-red-800 mb-1">Kode Tracking Tidak Ditemukan</h3>
              <p className="text-red-600 text-sm">{error}</p>
            </div>
          </div>
        )}

        {/* Order Result */}
        {order && (
          <div id="tracking-result" className="animate-fade-in-up">
            {/* Success header */}
            <div className="flex items-center gap-3 mb-6">
              <div className="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <div>
                <h2 className="text-xl font-black text-gray-900">Kode Tracking Ditemukan!</h2>
                <p className="text-gray-500 text-sm">Berikut adalah progres pesanan Anda.</p>
              </div>
            </div>

            {/* Tracking summary bar */}
            <div className="bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
              <div className="grid grid-cols-2 lg:grid-cols-4 divide-x divide-y lg:divide-y-0 divide-gray-100">
                <div className="p-5">
                  <div className="flex items-center gap-2 mb-1">
                    <div className="w-8 h-8 bg-[#1e3a6e] rounded-lg flex items-center justify-center">
                      <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                      </svg>
                    </div>
                    <span className="text-xs text-gray-400 font-medium">Kode Tracking</span>
                  </div>
                  <div className="text-xl font-black text-[#1e3a6e]">{order.tracking_code}</div>
                  <div className="text-xs text-gray-400">Dibuat pada {order.created_at}</div>
                </div>
                <div className="p-5">
                  <div className="flex items-center gap-1 text-xs text-gray-400 font-medium mb-1">
                    <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Tanggal Pesan
                  </div>
                  <div className="font-bold text-gray-800">{order.created_at}</div>
                </div>
                <div className="p-5">
                  <div className="flex items-center gap-1 text-xs text-gray-400 font-medium mb-1">
                    <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Estimasi Selesai
                  </div>
                  <div className="font-bold text-gray-800">{order.estimated_finish}</div>
                </div>
                <div className="p-5 bg-[#1e3a6e] text-white">
                  <div className="text-xs text-white/60 font-medium mb-1">Status Saat Ini</div>
                  <div className="flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" className="w-5 h-5" stroke="currentColor" strokeWidth="1.5">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                    </svg>
                    <div>
                      <div className="font-black text-lg leading-tight">{order.current_status_label}</div>
                      <div className="text-white/60 text-xs">{order.progress_percentage}% Selesai</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* Details + Timeline */}
            <div className="grid lg:grid-cols-5 gap-6">
              {/* Order Info */}
              <div className="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 className="font-bold text-gray-900 mb-5 text-base">Informasi Pesanan</h3>
                <dl className="space-y-4">
                  {[
                    {
                      icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />,
                      label: 'Nama Pemesan',
                      value: order.company_name || order.customer_name,
                    },
                    {
                      icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />,
                      label: 'No. WhatsApp',
                      value: order.whatsapp,
                    },
                    {
                      icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />,
                      label: 'Produk',
                      value: order.product_type,
                    },
                    {
                      icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />,
                      label: 'Jumlah',
                      value: `${order.quantity.toLocaleString('id-ID')} Pcs`,
                    },
                    {
                      icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />,
                      label: 'Warna',
                      value: order.color,
                    },
                    ...(order.notes ? [{
                      icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />,
                      label: 'Catatan',
                      value: order.notes,
                    }] : []),
                    ...(order.resi_number ? [{
                      icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />,
                      label: 'No. Resi',
                      value: order.resi_number,
                    }] : []),
                  ].map((item) => (
                    <div key={item.label} className="flex items-start gap-3">
                      <svg className="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {item.icon}
                      </svg>
                      <div className="min-w-0">
                        <dt className="text-xs text-gray-400 mb-0.5">{item.label}</dt>
                        <dd className="text-sm font-semibold text-gray-800 break-words">{item.value}</dd>
                      </div>
                    </div>
                  ))}
                </dl>
              </div>

              {/* Timeline */}
              <div className="lg:col-span-3 bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 className="font-bold text-gray-900 mb-5 text-base">Progres Produksi</h3>
                {order.timeline && (
                  <ProductionTimeline
                    timeline={order.timeline}
                    progressPercentage={order.progress_percentage}
                  />
                )}
              </div>
            </div>

            {/* Security notice */}
            <div className="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3">
              <svg className="w-5 h-5 text-[#1e3a6e] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              <div>
                <p className="text-sm font-semibold text-[#1e3a6e]">Data pesanan Anda aman dan hanya dapat diakses dengan kode tracking.</p>
                <p className="text-xs text-blue-600 mt-0.5">Jangan bagikan kode tracking kepada orang lain.</p>
              </div>
            </div>
          </div>
        )}

        {/* Idle state / features */}
        {!order && !error && !loading && (
          <div className="mt-4">
            <h2 className="text-xl font-black text-gray-800 text-center mb-8">Kenapa Cek Progres di MauJahit.id?</h2>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {[
                { icon: '🕐', title: 'Real-time Update', desc: 'Dapatkan informasi terbaru setiap tahap produksi.' },
                { icon: '🔍', title: 'Transparan', desc: 'Lihat proses produksi dengan jelas dan terbuka.' },
                { icon: '🛡️', title: 'Aman', desc: 'Data pesanan aman dan terjamin kerahasiaannya.' },
                { icon: '✨', title: 'Mudah', desc: 'Cukup masukkan kode tracking dan lihat progresnya.' },
              ].map((f) => (
                <div key={f.title} className="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                  <div className="text-3xl mb-3">{f.icon}</div>
                  <h3 className="font-bold text-gray-800 text-sm mb-1">{f.title}</h3>
                  <p className="text-gray-500 text-xs leading-relaxed">{f.desc}</p>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>

      <div className="flex-1" />
      <Footer />
    </div>
  );
}
