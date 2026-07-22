import type { Metadata } from 'next';
import Link from 'next/link';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';

export const metadata: Metadata = {
  title: 'MauJahit.id — Vendor Konveksi Terpercaya',
  description:
    'MauJahit.id adalah vendor konveksi terpercaya. Produksi pakaian berkualitas tinggi dengan sistem tracking produksi real-time.',
};

export default function HomePage() {
  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />

      {/* Hero */}
      <section className="relative bg-[#0d1f3c] text-white overflow-hidden">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute top-20 left-10 w-64 h-64 rounded-full bg-blue-400 blur-3xl" />
          <div className="absolute bottom-10 right-10 w-80 h-80 rounded-full bg-indigo-500 blur-3xl" />
        </div>
        <div className="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <div>
              <div className="inline-flex items-center gap-2 bg-white/10 text-white/80 px-4 py-2 rounded-full text-sm font-medium mb-6 backdrop-blur-sm border border-white/10">
                <span className="w-2 h-2 bg-green-400 rounded-full animate-pulse" />
                Sistem Tracking Produksi Real-Time
              </div>
              <h1 className="text-4xl lg:text-6xl font-black leading-tight mb-6">
                Konveksi
                <br />
                <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-cyan-300">
                  Terpercaya
                </span>
                <br />
                di Indonesia
              </h1>
              <p className="text-white/70 text-lg leading-relaxed mb-8 max-w-lg">
                Produksi pakaian berkualitas tinggi dengan sistem tracking real-time. Pantau setiap tahap produksi pesanan Anda secara transparan.
              </p>
              <div className="flex flex-wrap gap-4">
                <Link
                  href="/cek-progres"
                  className="bg-white text-[#1e3a6e] hover:bg-blue-50 font-bold px-8 py-3.5 rounded-xl transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2"
                >
                  <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                  Cek Progres Pesanan
                </Link>
                <Link
                  href="/tentang-kami"
                  className="border border-white/20 text-white hover:bg-white/10 font-medium px-8 py-3.5 rounded-xl transition-all duration-200"
                >
                  Tentang Kami
                </Link>
              </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-2 gap-4">
              {[
                { value: '500+', label: 'Pesanan Selesai', icon: '✅' },
                { value: '100+', label: 'Klien Puas', icon: '😊' },
                { value: '15+', label: 'Tahap Produksi', icon: '🔄' },
                { value: '24h', label: 'Update Real-Time', icon: '⚡' },
              ].map((stat) => (
                <div
                  key={stat.label}
                  className="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-colors"
                >
                  <div className="text-3xl mb-2">{stat.icon}</div>
                  <div className="text-3xl font-black text-white mb-1">{stat.value}</div>
                  <div className="text-white/60 text-sm">{stat.label}</div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* How it works */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-14">
            <h2 className="text-3xl lg:text-4xl font-black text-[#0d1f3c] mb-4">
              Cara Cek Progres Pesanan
            </h2>
            <p className="text-gray-500 text-lg max-w-xl mx-auto">
              Hanya 3 langkah mudah untuk memantau perkembangan produksi pakaian Anda
            </p>
          </div>
          <div className="grid md:grid-cols-3 gap-8">
            {[
              {
                step: '01',
                title: 'Dapatkan Kode Tracking',
                desc: 'Admin akan memberikan kode tracking unik seperti MJK-XXXXXX saat pesanan diterima.',
                icon: (
                  <svg className="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                  </svg>
                ),
              },
              {
                step: '02',
                title: 'Buka Halaman Cek Progres',
                desc: 'Akses menu "Cek Progres" di website MauJahit.id dan masukkan kode tracking Anda.',
                icon: (
                  <svg className="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                ),
              },
              {
                step: '03',
                title: 'Pantau Progres Real-Time',
                desc: 'Lihat timeline lengkap produksi, persentase penyelesaian, dan foto progres terkini.',
                icon: (
                  <svg className="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                ),
              },
            ].map((step, index) => (
              <div key={step.step} className="relative">
                <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative z-10">
                  <div className="w-14 h-14 bg-[#1e3a6e] rounded-2xl flex items-center justify-center text-white mb-5">
                    {step.icon}
                  </div>
                  <div className="text-xs font-bold text-[#1e3a6e] tracking-widest mb-2">LANGKAH {step.step}</div>
                  <h3 className="text-lg font-bold text-gray-900 mb-3">{step.title}</h3>
                  <p className="text-gray-500 text-sm leading-relaxed">{step.desc}</p>
                </div>
              </div>
            ))}
          </div>
          <div className="text-center mt-12">
            <Link
              href="/cek-progres"
              className="inline-flex items-center gap-2 bg-[#1e3a6e] hover:bg-[#132848] text-white font-bold px-10 py-4 rounded-xl transition-all duration-200 hover:shadow-xl hover:-translate-y-0.5 text-lg"
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Cek Progres Sekarang
            </Link>
          </div>
        </div>
      </section>

      {/* Features */}
      <section className="py-20 bg-white">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-14">
            <h2 className="text-3xl lg:text-4xl font-black text-[#0d1f3c] mb-4">
              Kenapa Pilih MauJahit.id?
            </h2>
          </div>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { emoji: '🕐', title: 'Real-time Update', desc: 'Dapatkan informasi terbaru setiap tahap produksi.' },
              { emoji: '🔍', title: 'Transparan', desc: 'Lihat proses produksi dengan jelas dan terbuka.' },
              { emoji: '🛡️', title: 'Aman', desc: 'Data pesanan aman dan terjamin kerahasiaannya.' },
              { emoji: '✨', title: 'Mudah', desc: 'Cukup masukkan kode tracking dan lihat progresnya.' },
            ].map((f) => (
              <div key={f.title} className="p-6 rounded-2xl bg-gray-50 border border-gray-100 hover:border-[#1e3a6e]/20 hover:shadow-md transition-all">
                <div className="text-4xl mb-4">{f.emoji}</div>
                <h3 className="font-bold text-gray-900 mb-2">{f.title}</h3>
                <p className="text-gray-500 text-sm">{f.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
}
