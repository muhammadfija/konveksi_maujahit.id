<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - MauJahit.id')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-900 overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen">
        <!-- Sidebar overlay for mobile -->
        <div class="fixed inset-0 bg-black/50 z-20 lg:hidden" x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity style="display: none;"></div>

        <!-- Sidebar -->
        <aside class="fixed lg:static inset-y-0 left-0 z-30 w-56 bg-[#0d1f3c] flex flex-col transition-transform duration-300 lg:translate-x-0"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

            <!-- Logo -->
            <div class="flex items-center gap-2.5 px-4 py-4 border-b border-white/10">
                <img src="{{ asset('logo.png') }}" alt="MauJahit.id" width="36" height="36" class="rounded-lg flex-shrink-0 object-cover">
                <div>
                    <div class="text-white font-black text-sm leading-tight">MAUJAHIT.ID</div>
                    <div class="text-white/40 text-[9px] tracking-widest uppercase">Clothing Vendor</div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-4 px-2">
                @php
                $role = session('admin_role', 'owner');
                
                $menuUtama = [];
                $menuUtama[] = ['href' => url('/admin/dashboard'), 'icon' => 'grid', 'label' => 'Dashboard', 'active' => request()->is('admin/dashboard')];
                $menuUtama[] = ['href' => url('/admin/pesanan'), 'icon' => 'list', 'label' => 'Pesanan', 'active' => request()->is('admin/pesanan')];
                
                if (in_array($role, ['owner', 'admin_cs'])) {
                    $menuUtama[] = ['href' => url('/admin/pesanan/baru'), 'icon' => 'plus-circle', 'label' => 'Tambah Pesanan', 'active' => request()->is('admin/pesanan/baru')];
                }

                $navItems = [
                    'MENU UTAMA' => $menuUtama,
                    'LAINNYA' => [
                        ['href' => url('/admin/profile'), 'icon' => 'user', 'label' => 'Profil Admin', 'active' => request()->is('admin/profile')],
                    ]
                ];
                @endphp

                @foreach($navItems as $section => $items)
                <div class="mb-5">
                    <div class="text-white/30 text-[9px] font-bold tracking-widest uppercase px-3 mb-2">
                        {{ $section }}
                    </div>
                    @foreach($items as $item)
                    <a href="{{ $item['href'] }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-0.5 text-sm transition-all duration-150 {{ $item['active'] ? 'bg-white text-[#1e3a6e] font-semibold shadow-sm' : 'text-white/60 hover:bg-white/10 hover:text-white' }}">

                        @if($item['icon'] === 'grid')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                        </svg>
                        @elseif($item['icon'] === 'list')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        @elseif($item['icon'] === 'plus-circle')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @elseif($item['icon'] === 'calendar')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        @elseif($item['icon'] === 'book-open')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        @elseif($item['icon'] === 'users')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        @elseif($item['icon'] === 'bar-chart')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        @elseif($item['icon'] === 'settings')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                        @elseif($item['icon'] === 'user')
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        @endif

                        <span class="truncate">{{ $item['label'] }}</span>
                    </a>
                    @endforeach
                </div>
                @endforeach
            </nav>

            <!-- Logout -->
            <div class="px-2 pb-4 border-t border-white/10 pt-3">
                <form action="{{ url('/admin/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors w-full">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

            <div class="px-4 pb-4">
                <p class="text-white/20 text-[9px] text-center">© {{ date('Y') }} MauJahit.id<br>All rights reserved.</p>
            </div>
        </aside>

        <!-- Main area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6 h-14 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <button class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100" @click="sidebarOpen = true" aria-label="Open menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    <button class="relative p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-[#1e3a6e] rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="hidden sm:block text-right">
                            <div class="text-sm font-semibold text-gray-800">{{ session('admin_name', 'Admin') }}</div>
                            <div class="text-xs text-gray-400 uppercase tracking-widest">{{ str_replace('_', ' ', session('admin_role', 'owner')) }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                @if (session('success'))
                <div class="p-4 mx-4 lg:mx-6 mt-6 bg-green-50 border border-green-200 rounded-2xl flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="pt-2">
                        <p class="font-bold text-green-800 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="p-4 mx-4 lg:mx-6 mt-6 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-red-700 text-sm font-bold">{{ session('error') }}</p>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>