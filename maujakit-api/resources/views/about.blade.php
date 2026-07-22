@extends('layouts.app')

@section('title', 'Tentang Kami - MauJahit.id')

@section('content')
<div class="bg-gray-50 pb-20">
  <!-- Header -->
  <div class="bg-[#0d1f3c] text-white py-20 text-center px-4 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMyMDQwNzAiIGZpbGwtb3BhY2l0eT0iMC4xNSI+PHBhdGggZD0iTTM2IDM0djZoNnYtNmgtNnptMCAwdjZoNnYtNmg2em0tNiAwdjZoNnYtNmgtNnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
    <div class="relative z-10 max-w-4xl mx-auto">
      <h1 class="text-4xl md:text-5xl font-black mb-6 tracking-tight">Tentang MauJahit.id</h1>
      <p class="text-lg text-white/70 font-medium leading-relaxed max-w-2xl mx-auto">
        Mitra produksi pakaian yang memadukan keahlian jahit profesional dengan transparansi teknologi modern.
      </p>
    </div>
  </div>

  <!-- Story Section -->
  <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100 -mt-32 relative z-20">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#1e3a6e] text-sm font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-[#1e3a6e]"></span>
            Sejarah Kami
          </div>
          <h2 class="text-3xl font-black text-gray-900 mb-6 tracking-tight">Lebih dari Sekadar Vendor Konveksi</h2>
          <div class="space-y-4 text-gray-600 leading-relaxed">
            <p>Maujahit adalah vendor konveksi pakaian profesional di Kabupaten Bandung yang menyediakan layanan produksi pakaian berkualitas dengan proses yang rapi, tepat waktu, dan harga yang kompetitif.</p>
            <p>Hingga saat ini, Maujahit telah dipercaya oleh ratusan klien untuk memenuhi berbagai kebutuhan produksi pakaian, mulai dari seragam, kaos, jaket, hoodie, hingga kebutuhan custom lainnya.</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#0d1f3c] to-[#1e3a6e] rounded-3xl p-10 text-white text-center">
          <div class="flex justify-center mb-6">
            <img src="{{ asset('logo.png') }}" alt="MauJahit.id Logo" width="120" height="120" class="rounded-2xl shadow-2xl">
          </div>
          <p class="text-white/70 text-sm leading-relaxed mt-4">
            "Kami berkomitmen memberikan kualitas terbaik di setiap proses produksi"
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Visi Misi -->
  <section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-10">
        <div class="bg-white rounded-2xl p-10 border border-gray-100 shadow-sm">
          <div class="w-12 h-12 bg-[#1e3a6e] rounded-xl flex items-center justify-center mb-5">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
          </div>
          <h3 class="text-2xl font-black text-gray-900 mb-4">Visi Kami</h3>
          <p class="text-gray-600 leading-relaxed">Menjadi perusahaan konveksi paling terpercaya di Indonesia yang dikenal karena kualitas produk, ketepatan waktu, dan inovasi transparansi layanan pelanggan.</p>
        </div>
        <div class="bg-white rounded-2xl p-10 border border-gray-100 shadow-sm">
          <div class="w-12 h-12 bg-[#1e3a6e] rounded-xl flex items-center justify-center mb-5">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
          </div>
          <h3 class="text-2xl font-black text-gray-900 mb-4">Misi Kami</h3>
          <ul class="text-gray-600 leading-relaxed space-y-3">
            <li class="flex items-start gap-2">
              <span class="text-green-500 mt-1">✓</span> Memberikan hasil jahitan dan sablon kualitas standar distro/premium.
            </li>
            <li class="flex items-start gap-2">
              <span class="text-green-500 mt-1">✓</span> Menerapkan SOP ketat untuk memastikan produksi selesai tepat waktu.
            </li>
            <li class="flex items-start gap-2">
              <span class="text-green-500 mt-1">✓</span> Mengembangkan sistem informasi berbasis web yang memudahkan pelanggan dalam memantau pesanan.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

</div>
@endsection
