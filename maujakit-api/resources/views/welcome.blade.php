@extends('layouts.app')

@section('title', 'MauJahit.id - Spesialis Produksi Kaos, Kemeja & Jaket Custom')

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#0d1f3c] overflow-hidden pt-20 pb-32 lg:pt-32 lg:pb-40">
  <div class="absolute inset-0">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMyMDQwNzAiIGZpbGwtb3BhY2l0eT0iMC4xNSI+PHBhdGggZD0iTTM2IDM0djZoNnYtNmgtNnptMCAwdjZoNnYtNmg2em0tNiAwdjZoNnYtNmgtNnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl"></div>
  </div>
  
  <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white/90 text-sm font-medium mb-8">
      <span class="w-2 h-2 rounded-full bg-green-400 pulse-ring"></span>
      Sistem Tracking Produksi Real-time
    </div>
    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white tracking-tight leading-tight mb-8">
      Konveksi Terpercaya,<br>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-300">
        Pantau Produksi
      </span> Dari HP Anda
    </h1>
    <p class="mt-4 text-xl text-white/70 max-w-3xl mx-auto font-medium leading-relaxed mb-10">
      MauJahit.id memberikan pengalaman produksi pakaian yang transparan. Lihat setiap tahap pesanan Anda, dari potong kain, jahit, hingga packing, secara langsung kapan saja.
    </p>
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <a href="{{ url('/cek-progres') }}" class="px-8 py-4 bg-white text-[#1e3a6e] rounded-xl font-bold text-lg hover:bg-gray-50 transition-all duration-300 shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:shadow-[0_0_60px_rgba(255,255,255,0.5)] transform hover:-translate-y-1">
        Cek Progres Pesanan
      </a>
      <a href="https://wa.me/6281297787795" target="_blank" rel="noopener noreferrer" class="px-8 py-4 bg-[#1e3a6e] border-2 border-[#2e5090] text-white rounded-xl font-bold text-lg hover:bg-[#2e5090] transition-all duration-300">
        Konsultasi Gratis
      </a>
    </div>
  </div>
</section>

<!-- Stats / Trust Indicators -->
<section class="py-10 bg-white border-b border-gray-100 relative -mt-10 rounded-t-[40px] z-10">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
      <div class="p-4">
        <div class="text-4xl font-black text-[#1e3a6e] mb-2">5+</div>
        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Tahun Pengalaman</div>
      </div>
      <div class="p-4">
        <div class="text-4xl font-black text-[#1e3a6e] mb-2">10K+</div>
        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Produk Selesai</div>
      </div>
      <div class="p-4">
        <div class="text-4xl font-black text-[#1e3a6e] mb-2">99%</div>
        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Tepat Waktu</div>
      </div>
      <div class="p-4">
        <div class="text-4xl font-black text-[#1e3a6e] mb-2">100%</div>
        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Transparan</div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-gray-50 overflow-hidden">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">Mengapa Memilih Kami?</h2>
      <p class="text-lg text-gray-600">Kami memadukan kualitas jahitan premium dengan teknologi terkini untuk memberikan pengalaman produksi yang tenang dan aman bagi pelanggan.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
      <!-- Feature 1 -->
      <div class="bg-white rounded-3xl p-10 border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
          <svg class="w-8 h-8 text-[#1e3a6e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4">Tracking Real-time</h3>
        <p class="text-gray-600 leading-relaxed">Tidak perlu lagi menebak-nebak atau menunggu balasan admin. Anda bisa pantau status pesanan kapan saja 24/7 menggunakan kode tracking unik.</p>
      </div>

      <!-- Feature 2 -->
      <div class="bg-gradient-to-br from-[#0d1f3c] to-[#1e3a6e] rounded-3xl p-10 shadow-2xl shadow-blue-900/20 transform md:-translate-y-4 hover:-translate-y-6 transition-all duration-300 group">
        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-4">Kualitas Premium</h3>
        <p class="text-white/80 leading-relaxed">Jahitan rapi, sablon presisi, dan bordir detail. Kami melakukan Quality Control ketat di setiap tahap produksi sebelum barang dikirim ke Anda.</p>
      </div>

      <!-- Feature 3 -->
      <div class="bg-white rounded-3xl p-10 border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
          <svg class="w-8 h-8 text-[#1e3a6e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4">Tepat Waktu</h3>
        <p class="text-gray-600 leading-relaxed">Kami sangat menghargai waktu Anda. Setiap pesanan dikerjakan sesuai dengan estimasi timeline yang telah disepakati di awal kontrak.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-20 relative overflow-hidden">
  <div class="absolute inset-0 bg-[#0d1f3c]"></div>
  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-500/20 rounded-full blur-[100px]"></div>
  
  <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
    <h2 class="text-4xl md:text-5xl font-black mb-8 tracking-tight">Siap Memulai Produksi Anda?</h2>
    <p class="text-xl text-white/70 mb-10 leading-relaxed">Konsultasikan kebutuhan desain dan spesifikasi bahan Anda sekarang. Tim kami siap membantu memberikan solusi terbaik.</p>
    <a href="https://wa.me/6281297787795" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-[#1e3a6e] rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
      </svg>
      Hubungi Admin Sekarang
    </a>
  </div>
</section>
@endsection
