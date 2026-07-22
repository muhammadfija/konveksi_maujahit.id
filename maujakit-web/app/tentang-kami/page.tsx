import type { Metadata } from 'next';
import Image from 'next/image';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';

export const metadata: Metadata = {
  title: 'Tentang Kami',
  description:
    'MauJahit.id adalah vendor konveksi terpercaya. Ketahui lebih lanjut tentang profil perusahaan, visi, misi, dan komitmen kami.',
};

export default function TentangKamiPage() {
  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />

      {/* Hero */}
      <section className="bg-[#0d1f3c] text-white py-20">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <div className="inline-flex items-center gap-2 bg-white/10 text-white/80 px-4 py-2 rounded-full text-sm font-medium mb-6">
            <span className="text-xl">🏭</span>
            Vendor Konveksi Terpercaya
          </div>
          <h1 className="text-4xl lg:text-5xl font-black mb-6 leading-tight">
            Tentang <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-cyan-300">MauJahit.id</span>
          </h1>
          <p className="text-white/70 text-lg max-w-2xl mx-auto leading-relaxed">
            Kami berkomitmen memberikan layanan produksi pakaian berkualitas tinggi dengan transparansi penuh melalui sistem tracking produksi real-time.
          </p>
        </div>
      </section>

      {/* Company Profile */}
      <section className="py-20 bg-white">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <div>
              <div className="inline-block bg-blue-50 text-[#1e3a6e] text-xs font-bold tracking-widest px-3 py-1 rounded-full uppercase mb-4">
                Profil Perusahaan
              </div>
              <h2 className="text-3xl font-black text-[#0d1f3c] mb-5">
                Siapa MauJahit.id?
              </h2>
              <p className="text-gray-600 leading-relaxed mb-6">
                Maujahit adalah vendor konveksi pakaian profesional di Kabupaten Bandung yang menyediakan layanan produksi pakaian berkualitas dengan proses yang rapi, tepat waktu, dan harga yang kompetitif. Hingga saat ini, Maujahit telah dipercaya oleh ratusan klien untuk memenuhi berbagai kebutuhan produksi pakaian, mulai dari seragam, kaos, jaket, hoodie, hingga kebutuhan custom lainnya.
              </p>
              <div className="grid grid-cols-2 gap-4">
                {[
                  { label: 'Tahun Berdiri', value: '2020' },
                  { label: 'Pesanan Selesai', value: '500+' },
                  { label: 'Klien Aktif', value: '100+' },
                  { label: 'Tim Produksi', value: '25+' },
                ].map((s) => (
                  <div key={s.label} className="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div className="text-2xl font-black text-[#1e3a6e]">{s.value}</div>
                    <div className="text-sm text-gray-500">{s.label}</div>
                  </div>
                ))}
              </div>
            </div>
            <div className="bg-gradient-to-br from-[#0d1f3c] to-[#1e3a6e] rounded-3xl p-10 text-white text-center">
              <div className="flex justify-center mb-6">
                <Image
                  src="/logo.png"
                  alt="MauJahit.id Logo"
                  width={120}
                  height={120}
                  className="rounded-2xl shadow-2xl"
                />
              </div>
              <p className="text-white/70 text-sm leading-relaxed mt-4">
                "Kami berkomitmen memberikan kualitas terbaik di setiap proses produksi"
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Visi Misi */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid md:grid-cols-2 gap-10">
            <div className="bg-white rounded-2xl p-10 border border-gray-100 shadow-sm">
              <div className="w-12 h-12 bg-[#1e3a6e] rounded-xl flex items-center justify-center mb-5">
                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
              <h2 className="text-2xl font-black text-[#0d1f3c] mb-4">Visi</h2>
              <p className="text-gray-600 leading-relaxed">
                Menjadi vendor konveksi terdepan di Indonesia yang memberikan solusi produksi pakaian berkualitas tinggi, tepat waktu, dan transparan melalui teknologi digital yang inovatif.
              </p>
            </div>
            <div className="bg-white rounded-2xl p-10 border border-gray-100 shadow-sm">
              <div className="w-12 h-12 bg-[#1e3a6e] rounded-xl flex items-center justify-center mb-5">
                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h2 className="text-2xl font-black text-[#0d1f3c] mb-4">Misi</h2>
              <ul className="space-y-3">
                {[
                  'Menyediakan produksi pakaian dengan bahan berkualitas tinggi',
                  'Memberikan transparansi penuh melalui sistem tracking real-time',
                  'Memastikan ketepatan waktu dalam setiap proses produksi',
                  'Memberikan layanan pelanggan yang responsif dan profesional',
                  'Terus berinovasi dalam teknologi dan proses produksi',
                ].map((m) => (
                  <li key={m} className="flex items-start gap-3 text-gray-600 text-sm">
                    <svg className="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                    {m}
                  </li>
                ))}
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* Layanan */}
      <section className="py-20 bg-white">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-14">
            <h2 className="text-3xl font-black text-[#0d1f3c] mb-4">Layanan Kami</h2>
            <p className="text-gray-500 text-lg">Berbagai jenis produk pakaian yang kami produksi</p>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            {[
              { emoji: '👕', label: 'Kaos' },
              { emoji: '🧥', label: 'Hoodie' },
              { emoji: '👔', label: 'Kemeja' },
              { emoji: '🧣', label: 'Jaket' },
              { emoji: '👖', label: 'Celana' },
              { emoji: '🎽', label: 'Seragam' },
            ].map((s) => (
              <div key={s.label} className="text-center bg-gray-50 rounded-2xl p-6 hover:bg-[#1e3a6e] hover:text-white group transition-all duration-200 border border-gray-100 cursor-default">
                <div className="text-4xl mb-3">{s.emoji}</div>
                <div className="text-sm font-semibold text-gray-700 group-hover:text-white">{s.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
}
