<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Calping Coffee')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Bebas+Neue&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/calpinglogoico-removebg-preview.png') }}">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em; }
        
        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-stone-900 antialiased flex flex-col min-h-screen">
    
    <!-- Sticky Navigation -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-white border-b border-stone-100 h-20" 
         x-data="{ scrolled: false, mobileNav: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 50)" 
         :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm h-16' : 'h-20'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between items-center h-full">
                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <span class="font-bold text-2xl md:text-3xl tracking-tight font-heading text-stone-900 uppercase">
                        Calping Coffee
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-semibold transition text-xs uppercase tracking-widest text-stone-600 hover:text-stone-900">Beranda</a>
                    <a href="{{ route('ourstory') }}" class="font-semibold transition text-xs uppercase tracking-widest text-stone-600 hover:text-stone-900">Cerita Kami</a>
                    <a href="{{ route('location') }}" class="font-semibold transition text-xs uppercase tracking-widest text-stone-600 hover:text-stone-900">Lokasi</a>
                    
                    @if(!request()->routeIs('customer.index') && !request()->routeIs('customer.scan'))
                        <a href="{{ route('customer.index') }}" class="flex items-center gap-2 px-8 py-2.5 rounded-full font-bold transition-all text-xs uppercase tracking-widest bg-stone-900 text-white hover:bg-stone-800 hover:scale-105">
                            <span>Pesan Sekarang</span>
                        </a>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileNav = !mobileNav" class="focus:outline-none text-stone-900">
                        <svg x-show="!mobileNav" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileNav" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileNav" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden bg-white border-b border-stone-100 shadow-lg"
             style="display: none;"
             @click.away="mobileNav = false">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block py-2 px-3 font-bold text-xs uppercase tracking-widest text-stone-600">Beranda</a>
                <a href="{{ route('ourstory') }}" class="block py-2 px-3 font-bold text-xs uppercase tracking-widest text-stone-600">Cerita Kami</a>
                <a href="{{ route('location') }}" class="block py-2 px-3 font-bold text-xs uppercase tracking-widest text-stone-600">Lokasi</a>
                @if(!request()->routeIs('customer.index') && !request()->routeIs('customer.scan'))
                    <a href="{{ route('customer.index') }}" class="block py-4 px-3 mt-2 bg-stone-900 text-white text-center font-bold text-xs uppercase tracking-widest rounded-xl">
                        Pesan Sekarang
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="bg-stone-50 text-stone-900 py-20 border-t border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end gap-8 text-center md:text-left">
                <div>
                    <h2 class="font-heading font-bold text-4xl mb-6 tracking-tight uppercase">Calping Coffee</h2>
                    <ul class="space-y-3 text-xs font-semibold uppercase tracking-widest text-stone-500">
                        <li><a href="#" class="hover:text-stone-900 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('ourstory') }}" class="hover:text-stone-900 transition-colors">Cerita Kami</a></li>
                        <li><a href="{{ route('location') }}" class="hover:text-stone-900 transition-colors">Lokasi</a></li>
                    </ul>
                </div>
                
                <div class="md:text-right">
                    <div class="flex gap-4 mb-6 justify-center md:justify-end">
                        <a href="https://www.instagram.com/calpingkopi/" target="_blank" class="w-12 h-12 flex items-center justify-center border border-stone-200 text-stone-900 rounded-full hover:bg-stone-900 hover:text-white hover:border-stone-900 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-stone-400">&copy; {{ date('Y') }} Calping Coffee — All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Status Button -->
    @if((session('active_order_id') || (isset($activeOrder) && $activeOrder)) && !request()->routeIs('customer.order.status'))
        @php $orderId = session('active_order_id') ?? $activeOrder->id; @endphp
        <div class="fixed bottom-24 right-6 z-40">
             <a href="{{ route('customer.order.status', $orderId) }}" class="flex items-center gap-3 bg-stone-900 text-white px-6 py-4 rounded-full shadow-2xl transition-transform hover:scale-105 active:scale-95">
                <div class="relative flex items-center justify-center">
                    <span class="absolute inline-flex h-full w-full rounded-full bg-stone-400 opacity-75 animate-ping"></span>
                    <svg class="w-5 h-5 text-white relative" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="font-bold text-xs uppercase tracking-widest">Status Pesanan</span>
             </a>
        </div>
    @endif

    @stack('scripts')
</body>
</html>
