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

<!-- Kategori Produk Section -->
<section class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Section Header -->
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">Kategori Produk</h2>
      <p class="text-gray-500 text-base">Kategori produk andalan</p>
    </div>

    @php
    $categories = [
      ['id' => 'tas', 'name' => 'TAS', 'images' => [
        'https://maujahit.com/storage/products/01KAD0DK6F8S0B4EQK248TCNKF.jpg',
        'https://maujahit.com/storage/products/01KAD0GVC0YPA6K47Y0CCWAADR.jpg',
        'https://maujahit.com/storage/products/01KAD15TJA5EYYMKX1VKAZ7S6R.png',
        'https://maujahit.com/storage/products/01KAD16CNPBRH7RHXZ8TY49JR3.png',
      ]],
      ['id' => 'kemeja', 'name' => 'KEMEJA', 'images' => [
        'https://maujahit.com/storage/products/01KADFTHXGYWNVZMTPCQVJQ189.png',
        'https://maujahit.com/storage/products/01KADFVANZC48VZQQMG5VM9CJ1.png',
        'https://maujahit.com/storage/products/01KADFVXJ4CVM85XY25CHC7S3H.png',
        'https://maujahit.com/storage/products/01KADFWJ97ENKVF0BVV1F4AVQ9.png',
        'https://maujahit.com/storage/products/01KA8MZYCXY5Q5W4FWMDSZYF85.png',
        'https://maujahit.com/storage/products/01KA8MFS2YVHKVF314JDBXA89S.png',
        'https://maujahit.com/storage/products/01KA8MJCD8B6G5SKQP2P9DSYYV.png',
        'https://maujahit.com/storage/products/01KA8MM4187DY19R13Z010X73W.png',
      ]],
      ['id' => 'rompi', 'name' => 'ROMPI', 'images' => [
        'https://maujahit.com/storage/products/01KA8KPPJT87HX0V4KN4540FMA.png',
        'https://maujahit.com/storage/products/01KA8KR6TXZJW9KEGQY8X7Z1RD.png',
        'https://maujahit.com/storage/products/01KA8JWRQHGZ2CSZQMM0K29QGE.png',
        'https://maujahit.com/storage/products/01KA8JXNC65BCM2QXNXQCM7MAM.png',
        'https://maujahit.com/storage/products/01KA8K1G9D10PBXT8N70GNSYC3.png',
        'https://maujahit.com/storage/products/01KA8MB4ZHA7B056NH35ED4K29.png',
      ]],
      ['id' => 'jaket', 'name' => 'JAKET', 'images' => [
        'https://maujahit.com/storage/products/01KA8C91QJ79C6DQF6356EVDQV.png',
        'https://maujahit.com/storage/products/01KA8CACHF7V6ZMHTA110W0DMX.png',
        'https://maujahit.com/storage/products/01KA8CB06MW6T8ZKSVR6J9JGCM.png',
        'https://maujahit.com/storage/products/01KA8CBNCHA1KMD26MYSB1XVMJ.png',
        'https://maujahit.com/storage/products/01KA8CDMYZ7TPM3BV0RBT7Q018.png',
        'https://maujahit.com/storage/products/01KA8CDZFZ4Y89NCJV1N0A5G41.png',
        'https://maujahit.com/storage/products/01KA8CE94YN1KS4KKQ9Q2MS0G6.png',
        'https://maujahit.com/storage/products/01KA8CER47YRN789D2G8MDQACR.png',
      ]],
      ['id' => 'kaos_pendek', 'name' => 'KAOS PENDEK', 'images' => [
        'https://maujahit.com/storage/products/01KA7YD7GJSSGN7EFX46MCZ2M9.png',
        'https://maujahit.com/storage/products/01KA7ZD818Q856VS9E2HET9SMD.png',
        'https://maujahit.com/storage/products/01KA7ZN64SRBDC3THQMRJDFMES.png',
        'https://maujahit.com/storage/products/01KA89PX4Q7T5H1VANGF9QZARE.png',
        'https://maujahit.com/storage/products/01KA89N027GJKXFRM03TSBHAR2.png',
        'https://maujahit.com/storage/products/01KA89TE9KG59SKAASZ75ZY9MG.png',
        'https://maujahit.com/storage/products/01KA89Z5RFYT1GGFJVFCBMS81Q.png',
      ]],
      ['id' => 'jersey', 'name' => 'JERSEY', 'images' => [
        'https://maujahit.com/storage/products/01KA7XKZYMHWXMPGDZAV25TGMG.png',
        'https://maujahit.com/storage/products/01KA7X78XV88HYA5G5FQNPVZGT.png',
        'https://maujahit.com/storage/products/01KA7XWC53AZMFFT21TJEXH7WX.png',
        'https://maujahit.com/storage/products/01KA7XY3H6JQF1WCES6PNNGERM.png',
        'https://maujahit.com/storage/products/01KA7Y02Z17TT0HJ68X6YMJRYE.png',
        'https://maujahit.com/storage/products/01KA7Y0FB9VZPV36QVDXMK2E9C.png',
        'https://maujahit.com/storage/products/01KA7Y1KWRRB91MXYVFTA1K4ZB.png',
      ]],
      ['id' => 'polo', 'name' => 'POLO SHIRT', 'images' => [
        'https://maujahit.com/storage/products/01KA8N6XZ88YQH3PDDX01S98HJ.png',
        'https://maujahit.com/storage/products/01KA7WGFK6VY4YGHWHCN8MD75C.jpeg',
        'https://maujahit.com/storage/products/01KA7X6A8RGTWTYRAPZD9W9001.jpeg',
        'https://maujahit.com/storage/products/01KA7XGP05YT616SC7VVMHMJ37.jpeg',
      ]],
      ['id' => 'kaos_panjang', 'name' => 'KAOS PANJANG', 'images' => [
        'https://maujahit.com/storage/products/01KA7WJ96NX3AYFR4KPVG2YGNW.jpeg',
        'https://maujahit.com/storage/products/01KA7WM8YRAP6WQMVYZTVYT32F.jpeg',
        'https://maujahit.com/storage/products/01KA81DQTHZQAB66KW9Q35Q6J2.jpg',
        'https://maujahit.com/storage/products/01KA8248B5D1MEJSDXG1GB2Q53.png',
        'https://maujahit.com/storage/products/01KA828BK6QYFJF5316P9GSGE2.png',
      ]],
    ];
    @endphp

    <div class="produk-grid">
      @foreach($categories as $catIdx => $category)
        @php
          $images = $category['images'];
          $delay  = 2800 + $catIdx * 350;
        @endphp
        <div class="produk-card"
             x-data="{
               activeIndex: 0,
               images: {{ json_encode($images) }},
               timer: null,
               init() { this.startSlide(); },
               startSlide() {
                 this.timer = setInterval(() => {
                   this.activeIndex = (this.activeIndex + 1) % this.images.length;
                 }, {{ $delay }});
               },
               stopSlide() { clearInterval(this.timer); },
               pick(i) { this.activeIndex = i; this.stopSlide(); this.startSlide(); }
             }">

          <!-- Judul -->
          <h3 style="font-size:1rem;font-weight:900;letter-spacing:.1em;text-align:center;margin-bottom:1rem;text-transform:uppercase;color:#111827;">{{ $category['name'] }}</h3>

          <!-- Gambar Utama -->
          <div class="produk-main-img" @mouseenter="stopSlide" @mouseleave="startSlide">
            @foreach($images as $idx => $img)
              <img src="{{ $img }}"
                   x-show="activeIndex === {{ $idx }}"
                   x-transition.opacity.duration.400ms
                   alt="{{ $category['name'] }}"
                   @if($idx > 0) style="display:none" @endif />
            @endforeach
          </div>

          <!-- Thumbnails -->
          <div class="produk-thumbs">
            @foreach($images as $idx => $img)
              <button @click="pick({{ $idx }})"
                      class="produk-thumb-btn"
                      :class="activeIndex === {{ $idx }} ? 'active' : 'inactive'">
                <img src="{{ $img }}" alt="{{ $category['name'] }}" loading="lazy" />
              </button>
            @endforeach
          </div>

        </div>
      @endforeach
    </div>

  </div>
</section>


<!-- Galeri Kegiatan Section -->
<section style="padding:5rem 0;background:#f9fafb;"
         x-data="{
           open: false,
           type: '',
           src: '',
           caption: '',
           openItem(t,s,c){ this.type=t; this.src=s; this.caption=c; this.open=true; },
           close(){ this.open=false; this.src=''; }
         }">

  <div style="max-width:1280px;margin:0 auto;padding:0 2rem;">

    <!-- Header -->
    <div style="text-align:center;margin-bottom:3rem;">
      <h2 style="font-size:2.25rem;font-weight:900;color:#111827;margin-bottom:0.5rem;">Galeri Kegiatan</h2>
      <p style="color:#6b7280;font-size:1rem;">Galeri Foto</p>
    </div>

    <!-- Grid: 4 kolom, 2 baris -->
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">

      @php
      $items = [
        ['type'=>'video','src'=>'https://youtube.com/embed/JQ7DW-xbVIs?autoplay=1','thumb'=>'https://i.ytimg.com/vi/JQ7DW-xbVIs/hqdefault.jpg','caption'=>'Semangat Produksi'],
        ['type'=>'video','src'=>'https://www.youtube.com/embed/nBV5av31p8I?autoplay=1','thumb'=>'https://i.ytimg.com/vi/nBV5av31p8I/hqdefault.jpg','caption'=>'Produksi 1.200 PCS'],
        ['type'=>'video','src'=>'https://www.youtube.com/embed/PnPcQADIoiY?autoplay=1','thumb'=>'https://i.ytimg.com/vi/PnPcQADIoiY/hqdefault.jpg','caption'=>'Kegiatan Tim Menjahit'],
        ['type'=>'photo','src'=>'https://maujahit.com/storage/01KA80CYA9Z34K9SHDQWR8BTYS.jpg','thumb'=>'https://maujahit.com/storage/01KA80CYA9Z34K9SHDQWR8BTYS.jpg','caption'=>'Proses Produksi'],
        ['type'=>'video','src'=>'https://www.youtube.com/embed/KXFGiaEcvtY?autoplay=1','thumb'=>'https://i.ytimg.com/vi/KXFGiaEcvtY/hqdefault.jpg','caption'=>'Client Mau Jahit'],
        ['type'=>'photo','src'=>'https://maujahit.com/storage/01KA80BB3KED2YXXGW6PH5SEF8.jpg','thumb'=>'https://maujahit.com/storage/01KA80BB3KED2YXXGW6PH5SEF8.jpg','caption'=>'Kunjungan Artis Ali Syakieb'],
        ['type'=>'video','src'=>'https://www.youtube.com/embed/wbLeFg1tRgY?autoplay=1','thumb'=>'https://i.ytimg.com/vi/wbLeFg1tRgY/hqdefault.jpg','caption'=>'Company Profile Mau Jahit'],
        ['type'=>'video','src'=>'https://www.youtube.com/embed/0rfv95bcSA0?autoplay=1','thumb'=>'https://i.ytimg.com/vi/0rfv95bcSA0/hqdefault.jpg','caption'=>'Proses Produksi di Maujahit'],
        ['type'=>'photo','src'=>'https://maujahit.com/storage/01K9Y37Q9PMD26WRN8QTV68MRJ.jpg','thumb'=>'https://maujahit.com/storage/01K9Y37Q9PMD26WRN8QTV68MRJ.jpg','caption'=>'Foto Bersama All Team Maujahit'],
        ['type'=>'photo','src'=>'https://maujahit.com/storage/01K9Y38JZ2QD02EA6PH9YV6DVS.jpeg','thumb'=>'https://maujahit.com/storage/01K9Y38JZ2QD02EA6PH9YV6DVS.jpeg','caption'=>'Proses Produksi'],
      ];
      @endphp

      @foreach($items as $item)
        <div
          @click="openItem('{{ $item['type'] }}','{{ $item['src'] }}','{{ $item['caption'] }}')"
          style="position:relative;overflow:hidden;border-radius:10px;cursor:pointer;height:200px;background:#e5e7eb;"
          onmouseenter="this.querySelector('img').style.transform='scale(1.06)';this.querySelector('.gi-overlay').style.background='rgba(0,0,0,0.48)';"
          onmouseleave="this.querySelector('img').style.transform='scale(1)';this.querySelector('.gi-overlay').style.background='rgba(0,0,0,0)';">

          <img src="{{ $item['thumb'] }}" alt="{{ $item['caption'] }}"
               style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" />

          <div class="gi-overlay"
               style="position:absolute;inset:0;background:rgba(0,0,0,0);display:flex;flex-direction:column;align-items:center;justify-content:center;transition:background 0.3s;gap:8px;">
            @if($item['type'] === 'video')
              <div style="width:52px;height:52px;border:2px solid white;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.2);">
                <svg viewBox="0 0 24 24" fill="white" width="28" height="28"><path d="M8 5v14l11-7z"/></svg>
              </div>
            @endif
            <span style="color:white;font-size:0.75rem;font-weight:700;text-align:center;padding:0 10px;text-shadow:0 1px 4px rgba(0,0,0,0.7);">{{ $item['caption'] }}</span>
          </div>
        </div>
      @endforeach

    </div>
  </div>

  <!-- Lightbox Modal -->
  <div :style="open
         ? 'position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.85);z-index:99999;display:flex;align-items:center;justify-content:center;padding:1.5rem;box-sizing:border-box;'
         : 'display:none;'">

    <!-- Card Modal -->
    <div style="position:relative;width:100%;max-width:1000px;background:#111827;border-radius:20px;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,0.7);">

      <!-- Header bar -->
      <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;background:#1f2937;border-bottom:1px solid rgba(255,255,255,0.08);">
        <div style="display:flex;align-items:center;gap:0.6rem;">
          <!-- Dot indicator (type icon) -->
          <div x-show="type === 'video'"
               style="width:10px;height:10px;border-radius:50%;background:#ef4444;"></div>
          <div x-show="type === 'photo'"
               style="width:10px;height:10px;border-radius:50%;background:#3b82f6;"></div>
          <span x-text="caption"
                style="color:rgba(255,255,255,0.85);font-size:0.9rem;font-weight:600;letter-spacing:0.02em;"></span>
        </div>
        <!-- Tombol Close -->
        <button @click="close()"
                style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.1);border:1.5px solid rgba(255,255,255,0.25);color:white;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.2s;"
                onmouseenter="this.style.background='rgba(239,68,68,0.7)'"
                onmouseleave="this.style.background='rgba(255,255,255,0.1)'">✕</button>
      </div>

      <!-- Konten -->
      <div style="padding:1.5rem;">

        <!-- Video -->
        <div x-show="type === 'video'"
             style="position:relative;padding-bottom:56.25%;border-radius:12px;overflow:hidden;background:#000;">
          <iframe :src="src"
                  style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"
                  allow="autoplay;encrypted-media;fullscreen"
                  allowfullscreen></iframe>
        </div>

        <!-- Foto -->
        <div x-show="type === 'photo'" style="display:flex;justify-content:center;align-items:center;background:#000;border-radius:12px;overflow:hidden;">
          <img :src="src" :alt="caption"
               style="width:100%;max-height:80vh;object-fit:contain;display:block;" />
        </div>

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
