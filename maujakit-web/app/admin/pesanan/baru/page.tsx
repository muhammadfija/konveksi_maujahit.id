'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { ordersApi } from '@/lib/api';

export default function TambahPesananPage() {
  const router = useRouter();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [isCustomProduct, setIsCustomProduct] = useState(false);
  const [form, setForm] = useState({
    customer_name: '',
    whatsapp: '',
    company_name: '',
    product_type: '',
    quantity: '',
    color: '',
    notes: '',
    estimated_finish: '',
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleProductTypeChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    if (e.target.value === 'Lainnya') {
      setIsCustomProduct(true);
      setForm({ ...form, product_type: '' });
    } else {
      setIsCustomProduct(false);
      setForm({ ...form, product_type: e.target.value });
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setSuccess('');

    try {
      const res = await ordersApi.create({
        ...form,
        quantity: parseInt(form.quantity),
      }) as { success: boolean; message: string; data: { tracking_code: string } };

      if (res.success) {
        setSuccess(`Pesanan berhasil dibuat! Kode Tracking: ${res.data.tracking_code}`);
        setTimeout(() => router.push('/admin/pesanan'), 2500);
      } else {
        setError(res.message || 'Gagal membuat pesanan.');
      }
    } catch (err: unknown) {
      setError(err instanceof Error ? err.message : 'Terjadi kesalahan.');
    } finally {
      setLoading(false);
    }
  };

  const productTypes = [
    'Kaos Combed 24s', 'Kaos Combed 30s', 'Kaos Bambu',
    'Hoodie Premium', 'Hoodie Fleece', 'Crewneck',
    'Kemeja', 'Poloshirt', 'Jaket Varsity',
    'Celana Training', 'Kaos Oversize', 'Seragam Sekolah',
    'Seragam Kantor', 'Lainnya',
  ];

  return (
    <div className="p-4 lg:p-6 max-w-3xl">
      {/* Header */}
      <div className="flex items-center gap-3 mb-6">
        <Link
          href="/admin/pesanan"
          className="p-2 hover:bg-gray-100 rounded-xl text-gray-500 transition-colors"
        >
          <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </Link>
        <div>
          <h1 className="text-xl font-black text-gray-900">Tambah Pesanan Baru</h1>
          <p className="text-gray-500 text-sm">Isi data pesanan di bawah ini. Kode tracking akan dibuat otomatis.</p>
        </div>
      </div>

      {success && (
        <div className="mb-5 bg-green-50 border border-green-200 rounded-2xl p-5 flex items-start gap-3">
          <div className="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg className="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div>
            <p className="font-bold text-green-800">Pesanan Berhasil Dibuat!</p>
            <p className="text-green-700 text-sm mt-0.5">{success}</p>
            <p className="text-green-600 text-xs mt-1">Mengarahkan ke halaman pesanan...</p>
          </div>
        </div>
      )}

      {error && (
        <div className="mb-5 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center gap-3">
          <svg className="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
          <p className="text-red-700 text-sm">{error}</p>
        </div>
      )}

      <form onSubmit={handleSubmit} className="bg-white rounded-2xl border border-gray-100 shadow-sm">
        {/* Info Pelanggan */}
        <div className="p-6 border-b border-gray-100">
          <h2 className="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <div className="w-6 h-6 bg-[#1e3a6e] text-white rounded-lg flex items-center justify-center text-xs font-bold">1</div>
            Informasi Pelanggan
          </h2>
          <div className="grid sm:grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Nama Pelanggan <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="customer_name"
                value={form.customer_name}
                onChange={handleChange}
                required
                placeholder="Nama lengkap pelanggan"
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e]"
              />
            </div>
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Nomor WhatsApp <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="whatsapp"
                value={form.whatsapp}
                onChange={handleChange}
                required
                placeholder="08xxxxxxxxxx"
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e]"
              />
            </div>
            <div className="sm:col-span-2">
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Nama Perusahaan <span className="text-gray-400 font-normal">(opsional)</span>
              </label>
              <input
                type="text"
                name="company_name"
                value={form.company_name}
                onChange={handleChange}
                placeholder="Nama perusahaan atau instansi"
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e]"
              />
            </div>
          </div>
        </div>

        {/* Detail Pesanan */}
        <div className="p-6 border-b border-gray-100">
          <h2 className="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <div className="w-6 h-6 bg-[#1e3a6e] text-white rounded-lg flex items-center justify-center text-xs font-bold">2</div>
            Detail Pesanan
          </h2>
          <div className="grid sm:grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Jenis Produk <span className="text-red-500">*</span>
              </label>
              {!isCustomProduct ? (
                <select
                  name="product_type"
                  value={form.product_type}
                  onChange={handleProductTypeChange}
                  required
                  className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e] bg-white"
                >
                  <option value="">Pilih jenis produk...</option>
                  {productTypes.map(p => <option key={p} value={p}>{p}</option>)}
                </select>
              ) : (
                <div className="flex gap-2">
                  <input
                    type="text"
                    name="product_type"
                    value={form.product_type}
                    onChange={handleChange}
                    required
                    autoFocus
                    placeholder="Ketik jenis produk..."
                    className="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e]"
                  />
                  <button
                    type="button"
                    onClick={() => {
                      setIsCustomProduct(false);
                      setForm({ ...form, product_type: '' });
                    }}
                    className="px-3 border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 transition-colors flex items-center justify-center"
                    title="Batal, pilih dari daftar"
                  >
                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              )}
            </div>
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Jumlah Pesanan (Pcs) <span className="text-red-500">*</span>
              </label>
              <input
                type="number"
                name="quantity"
                value={form.quantity}
                onChange={handleChange}
                required
                min={1}
                placeholder="100"
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e]"
              />
            </div>
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Warna Produk <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                name="color"
                value={form.color}
                onChange={handleChange}
                required
                placeholder="Hitam, Putih, Navy..."
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e]"
              />
            </div>
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Estimasi Tanggal Selesai <span className="text-red-500">*</span>
              </label>
              <input
                type="date"
                name="estimated_finish"
                value={form.estimated_finish}
                onChange={handleChange}
                required
                min={new Date().toISOString().split('T')[0]}
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e]"
              />
            </div>
            <div className="sm:col-span-2">
              <label className="block text-sm font-semibold text-gray-700 mb-1.5">
                Catatan Pesanan <span className="text-gray-400 font-normal">(opsional)</span>
              </label>
              <textarea
                name="notes"
                value={form.notes}
                onChange={handleChange}
                rows={3}
                placeholder="Catatan tambahan seperti ukuran, desain khusus, sablon, bordir, dll."
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/30 focus:border-[#1e3a6e] resize-none"
              />
            </div>
          </div>
        </div>

        {/* Info box */}
        <div className="px-6 py-4 bg-blue-50 border-b border-gray-100 rounded-none">
          <div className="flex items-start gap-3">
            <svg className="w-5 h-5 text-[#1e3a6e] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p className="text-sm font-semibold text-[#1e3a6e]">Kode Tracking Otomatis</p>
              <p className="text-xs text-blue-600 mt-0.5">Sistem akan menghasilkan kode tracking unik (contoh: MJK-XXXXXX) secara otomatis setelah pesanan disimpan. Berikan kode tersebut kepada pelanggan untuk tracking produksi.</p>
            </div>
          </div>
        </div>

        {/* Actions */}
        <div className="p-6 flex gap-3 justify-end">
          <Link
            href="/admin/pesanan"
            className="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors"
          >
            Batal
          </Link>
          <button
            type="submit"
            disabled={loading}
            id="submit-order-btn"
            className="px-8 py-2.5 bg-[#1e3a6e] hover:bg-[#132848] disabled:bg-gray-300 text-white rounded-xl text-sm font-bold transition-colors flex items-center gap-2"
          >
            {loading ? (
              <>
                <div className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full spinner" />
                Menyimpan...
              </>
            ) : (
              <>
                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                </svg>
                Simpan Pesanan
              </>
            )}
          </button>
        </div>
      </form>
    </div>
  );
}
