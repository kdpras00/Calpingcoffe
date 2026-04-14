<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CalpingPos')</title>

    <!-- Tuku-Exact Fonts: DM Mono & Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Nunito:wght@400;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/calpinglogoico-removebg-preview.png') }}">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'DM Mono', monospace; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Quicksand', sans-serif; letter-spacing: -0.02em; }
        
        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-coffee-200 text-coffee-900 dark:bg-stone-950 dark:text-white antialiased flex flex-col min-h-screen">
    
    <!-- Sticky Navigation (Standardized Fixed Height) -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-white border-b border-stone-100 h-20" 
         x-data="{ scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 50)" 
         :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm h-16' : 'h-20'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between items-center h-full">
                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <span class="font-bold text-2xl tracking-tighter font-heading text-coffee-900">
                        calpingCoffee
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-bold transition text-sm text-coffee-700 hover:text-coffee-900">Beranda</a>
                    <a href="{{ route('ourstory') }}" class="font-bold transition text-sm text-coffee-700 hover:text-coffee-900">Cerita Kami</a>
                    <a href="{{ route('location') }}" class="font-bold transition text-sm text-coffee-700 hover:text-coffee-900">Lokasi</a>
                    
                    @if(!request()->routeIs('customer.index') && !request()->routeIs('customer.scan'))
                        <a href="{{ route('customer.index') }}" class="flex items-center gap-2 px-6 py-2 rounded-full font-bold shadow-sm transition-all text-sm bg-coffee-900 text-white hover:bg-black">
                            <span>Pesan Sekarang</span>
                        </a>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="focus:outline-none text-coffee-900">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="bg-coffee-200 text-coffee-900 py-12 border-t border-coffee-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end gap-8">
                <div>
                    <h2 class="font-heading font-bold text-3xl mb-4 tracking-tighter">calpingCoffee</h2>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                        <li><a href="{{ route('ourstory') }}" class="hover:underline">Cerita Kami</a></li>
                        <li><a href="{{ route('location') }}" class="hover:underline">Lokasi</a></li>
                    </ul>
                </div>
                
                <div class="text-right">
                    <div class="flex gap-4 mb-4 justify-end">
                        <a href="https://www.instagram.com/calpingkopi/" target="_blank" class="w-10 h-10 flex items-center justify-center bg-coffee-900 text-white rounded-full hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-widest opacity-60">&copy; {{ date('Y') }} Calping</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Status Button -->
    @if((session('active_order_id') || (isset($activeOrder) && $activeOrder)) && !request()->routeIs('customer.order.status'))
        @php $orderId = session('active_order_id') ?? $activeOrder->id; @endphp
        <div class="fixed bottom-24 right-4 z-40">
             <a href="{{ route('customer.order.status', $orderId) }}" class="flex items-center gap-2 bg-coffee-900 text-white px-4 py-3 rounded-full shadow-lg border border-coffee-800 hover:scale-105 transition-transform">
                <div class="relative flex items-center justify-center">
                    <span class="absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75 animate-ping"></span>
                    <svg class="w-5 h-5 text-white relative" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="font-bold text-sm pr-1">Status Pesanan</span>
             </a>
        </div>
    @endif

    @stack('scripts')
</body>
</html>
