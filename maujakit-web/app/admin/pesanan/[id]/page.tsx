'use client';

import { useEffect, useState } from 'react';
import { useParams, useRouter } from 'next/navigation';
import Link from 'next/link';
import { ordersApi } from '@/lib/api';
import { Order, STATUS_LABELS, ALL_STAGES, ProductionStatus } from '@/lib/types';
import ProductionTimeline from '@/components/ProductionTimeline';

export default function DetailPesananPage() {
  const { id } = useParams<{ id: string }>();
  const router = useRouter();
  const [order, setOrder] = useState<Order | null>(null);
  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState(false);
  const [uploadingPhoto, setUploadingPhoto] = useState(false);
  const [resi, setResi] = useState('');
  const [activeTab, setActiveTab] = useState<'timeline' | 'info'>('timeline');

  useEffect(() => {
    fetchOrder();
  }, [id]);

  const fetchOrder = async () => {
    setLoading(true);
    try {
      const res = await ordersApi.get(parseInt(id)) as { success: boolean; data: Order };
      setOrder(res.data);
      setResi(res.data.resi_number || '');
    } catch (e) {
      console.error(e);
    } finally {
      setLoading(false);
    }
  };

  const handleUpdateStatus = async (status: ProductionStatus) => {
    if (!order || updating) return;
    if (!confirm(`Update status ke "${STATUS_LABELS[status]}"?`)) return;

    setUpdating(true);
    try {
      await ordersApi.updateStatus(order.id, status);
      await fetchOrder();
    } catch (e) {
      alert('Gagal update status.');
    } finally {
      setUpdating(false);
    }
  };

  const handlePhotoUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    if (!order || !e.target.files?.[0]) return;
    const file = e.target.files[0];
    const formData = new FormData();
    formData.append('photo', file);
    formData.append('note', `Foto progres ${STATUS_LABELS[order.current_status]}`);

    setUploadingPhoto(true);
    try {
      await ordersApi.uploadPhoto(order.id, formData);
      await fetchOrder();
      alert('Foto berhasil diunggah!');
    } catch (e) {
      alert('Gagal upload foto.');
    } finally {
      setUploadingPhoto(false);
      e.target.value = '';
    }
  };

  const handleUpdateResi = async () => {
    if (!order || !resi.trim()) return;
    try {
      await ordersApi.update(order.id, { resi_number: resi });
      alert('Nomor resi berhasil disimpan!');
      await fetchOrder();
    } catch (e) {
      alert('Gagal menyimpan resi.');
    }
  };

  const currentStatusIndex = order ? ALL_STAGES.indexOf(order.current_status) : 0;
  const nextStatus = order && currentStatusIndex < ALL_STAGES.length - 1 ? ALL_STAGES[currentStatusIndex + 1] : null;

  if (loading) {
    return (
      <div className="flex justify-center items-center h-64">
        <div className="w-8 h-8 border-2 border-gray-200 border-t-[#1e3a6e] rounded-full spinner" />
      </div>
    );
  }

  if (!order) {
    return (
      <div className="p-6 text-center">
        <p className="text-gray-400">Pesanan tidak ditemukan.</p>
        <Link href="/admin/pesanan" className="text-[#1e3a6e] font-semibold mt-2 inline-block">← Kembali</Link>
      </div>
    );
  }

  return (
    <div className="p-4 lg:p-6">
      {/* Header */}
      <div className="flex items-center gap-3 mb-6">
        <Link href="/admin/pesanan" className="p-2 hover:bg-gray-100 rounded-xl text-gray-500">
          <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </Link>
        <div className="flex-1">
          <h1 className="text-xl font-black text-gray-900">Detail Pesanan</h1>
          <p className="text-gray-500 text-sm">{order.tracking_code}</p>
        </div>
        {/* Quick status update */}
        {nextStatus && (
          <button
            onClick={() => handleUpdateStatus(nextStatus)}
            disabled={updating}
            className="flex items-center gap-2 bg-[#1e3a6e] hover:bg-[#132848] disabled:bg-gray-300 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-colors"
          >
            {updating ? (
              <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full spinner" />
            ) : (
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            )}
            → {STATUS_LABELS[nextStatus]}
          </button>
        )}
      </div>

      {/* Summary bar */}
      <div className="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6 p-5">
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div>
            <p className="text-xs text-gray-400 mb-1">Tracking Code</p>
            <p className="font-black text-[#1e3a6e] font-mono">{order.tracking_code}</p>
          </div>
          <div>
            <p className="text-xs text-gray-400 mb-1">Pelanggan</p>
            <p className="font-semibold text-gray-800">{order.company_name || order.customer_name}</p>
          </div>
          <div>
            <p className="text-xs text-gray-400 mb-1">Status Saat Ini</p>
            <p className="font-semibold text-gray-800">{order.current_status_label}</p>
          </div>
          <div>
            <p className="text-xs text-gray-400 mb-1">Progress</p>
            <div className="flex items-center gap-2">
              <div className="flex-1 bg-gray-200 rounded-full h-2">
                <div
                  className="h-2 rounded-full bg-[#1e3a6e] transition-all duration-500"
                  style={{ width: `${order.progress_percentage}%` }}
                />
              </div>
              <span className="text-sm font-bold text-[#1e3a6e]">{order.progress_percentage}%</span>
            </div>
          </div>
        </div>
      </div>

      <div className="grid lg:grid-cols-3 gap-6">
        {/* Left: Info + Actions */}
        <div className="space-y-4">
          {/* Order Info */}
          <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 className="font-bold text-gray-900 mb-4">Informasi Pesanan</h3>
            <dl className="space-y-3">
              {[
                { label: 'Nama Pemesan', value: order.customer_name },
                { label: 'Perusahaan', value: order.company_name || '-' },
                { label: 'WhatsApp', value: order.whatsapp },
                { label: 'Produk', value: order.product_type },
                { label: 'Jumlah', value: `${order.quantity.toLocaleString()} Pcs` },
                { label: 'Warna', value: order.color },
                { label: 'Estimasi Selesai', value: order.estimated_finish },
                ...(order.notes ? [{ label: 'Catatan', value: order.notes }] : []),
              ].map((item) => (
                <div key={item.label} className="flex justify-between gap-2">
                  <dt className="text-xs text-gray-400 flex-shrink-0">{item.label}</dt>
                  <dd className="text-xs font-semibold text-gray-800 text-right">{item.value}</dd>
                </div>
              ))}
            </dl>
          </div>

          {/* Update Status */}
          <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 className="font-bold text-gray-900 mb-3">Update Status Produksi</h3>
            <div className="grid grid-cols-1 gap-1.5 max-h-56 overflow-y-auto">
              {ALL_STAGES.map((stage, i) => {
                const isCurrentOrDone = i <= currentStatusIndex;
                const isCurrent = stage === order.current_status;
                return (
                  <button
                    key={stage}
                    onClick={() => !isCurrent && handleUpdateStatus(stage)}
                    disabled={isCurrent || updating}
                    className={`text-left text-xs px-3 py-2 rounded-lg transition-all font-medium ${
                      isCurrent
                        ? 'bg-[#1e3a6e] text-white cursor-default'
                        : isCurrentOrDone
                        ? 'bg-green-50 text-green-700 hover:bg-green-100'
                        : 'bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-700'
                    }`}
                  >
                    {isCurrent ? '→ ' : isCurrentOrDone ? '✓ ' : ''}{STATUS_LABELS[stage]}
                  </button>
                );
              })}
            </div>
          </div>

          {/* Upload Photo */}
          <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 className="font-bold text-gray-900 mb-3">Upload Foto Progres</h3>
            <label
              htmlFor="photo-upload"
              className={`flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-xl p-5 cursor-pointer hover:border-[#1e3a6e] hover:bg-blue-50 transition-all ${uploadingPhoto ? 'opacity-50 pointer-events-none' : ''}`}
            >
              {uploadingPhoto ? (
                <div className="w-6 h-6 border-2 border-[#1e3a6e]/30 border-t-[#1e3a6e] rounded-full spinner" />
              ) : (
                <svg className="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              )}
              <span className="text-xs text-gray-400">Klik untuk upload foto</span>
              <span className="text-[10px] text-gray-300">JPG, PNG, WebP max 5MB</span>
            </label>
            <input
              id="photo-upload"
              type="file"
              accept="image/jpeg,image/png,image/webp"
              className="hidden"
              onChange={handlePhotoUpload}
            />
          </div>

          {/* Resi Number */}
          <div className="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 className="font-bold text-gray-900 mb-3">Nomor Resi Pengiriman</h3>
            <div className="flex gap-2">
              <input
                type="text"
                value={resi}
                onChange={(e) => setResi(e.target.value)}
                placeholder="Masukkan nomor resi..."
                className="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/20"
              />
              <button
                onClick={handleUpdateResi}
                className="px-4 py-2 bg-[#1e3a6e] hover:bg-[#132848] text-white text-sm font-bold rounded-xl transition-colors"
              >
                Simpan
              </button>
            </div>
            {order.resi_number && (
              <p className="text-xs text-gray-400 mt-2">Resi saat ini: <span className="font-semibold text-gray-700">{order.resi_number}</span></p>
            )}
          </div>
        </div>

        {/* Right: Timeline */}
        <div className="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <h3 className="font-bold text-gray-900 mb-5">Timeline Produksi</h3>
          {order.timeline && (
            <ProductionTimeline
              timeline={order.timeline}
              progressPercentage={order.progress_percentage}
            />
          )}
        </div>
      </div>
    </div>
  );
}
