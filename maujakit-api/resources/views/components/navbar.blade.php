<nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50" x-data="{ mobileOpen: false }">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <x-logo size="sm" variant="dark" />

      <!-- Desktop Nav -->
      <div class="hidden md:flex items-center gap-1">
        @php
          $links = [
            ['href' => url('/'), 'label' => 'Beranda', 'active' => request()->is('/')],
            ['href' => url('/tentang-kami'), 'label' => 'Tentang Kami', 'active' => request()->is('tentang-kami*')],
            ['href' => url('/cek-progres'), 'label' => 'Cek Progres', 'active' => request()->is('cek-progres*')],
          ];
        @endphp
        @foreach($links as $link)
          <a href="{{ $link['href'] }}"
             class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $link['active'] ? 'text-[#1e3a6e] bg-blue-50 border-b-2 border-[#1e3a6e]' : 'text-gray-600 hover:text-[#1e3a6e] hover:bg-gray-50' }}">
            {{ $link['label'] }}
          </a>
        @endforeach
        
        <div class="ml-4 pl-4 border-l border-gray-200 flex items-center">
          <a href="{{ url('/admin/login') }}" class="inline-block px-8 py-3 text-sm font-semibold tracking-wide text-white bg-[#1e3a6e] rounded-xl transition-colors hover:bg-[#132848] shadow-sm">
            Login Admin
          </a>
        </div>
      </div>

      <!-- Mobile hamburger -->
      <button class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100" @click="mobileOpen = !mobileOpen" aria-label="Toggle menu">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileOpen">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileOpen" style="display: none;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden py-3 border-t border-gray-100" x-show="mobileOpen" x-transition style="display: none;">
      @foreach($links as $link)
        <a href="{{ $link['href'] }}"
           @click="mobileOpen = false"
           class="block px-4 py-2.5 text-sm font-medium rounded-lg mx-1 mb-1 transition-colors {{ $link['active'] ? 'bg-blue-50 text-[#1e3a6e]' : 'text-gray-600 hover:bg-gray-50' }}">
          {{ $link['label'] }}
        </a>
      @endforeach
      <div class="border-t border-gray-100 mt-2 pt-2 px-1">
        <a href="{{ url('/admin/login') }}" class="block px-4 py-2.5 text-sm font-bold text-center text-white bg-[#1e3a6e] rounded-lg transition-colors hover:bg-[#132848]">
          Login Admin
        </a>
      </div>
    </div>
  </div>
</nav>
