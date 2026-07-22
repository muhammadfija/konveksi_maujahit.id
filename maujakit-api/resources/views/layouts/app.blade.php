<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF- current_time">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MauJahit.id - Jasa Konveksi Terpercaya')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen flex flex-col">
    
    <x-navbar />

    <main class="flex-1">
        @yield('content')
    </main>

    <x-footer />
    
</body>
</html>
