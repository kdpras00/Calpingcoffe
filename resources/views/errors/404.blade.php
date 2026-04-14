<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 dark:bg-stone-950">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl w-full text-center">
            <!-- 404 Illustration -->
            <div class="mb-8">
                <div class="relative">
                    <!-- Coffee Cup SVG -->
                    <svg class="w-64 h-64 mx-auto text-stone-300 dark:text-stone-700" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 14h18M3 14a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v6a2 2 0 01-2 2M3 14l1.5 5.5A2 2 0 006.5 21h7a2 2 0 002-1.5L17 14m4-4h-2a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2z"/>
                    </svg>
                    
                    <!-- 404 Number -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h1 class="text-8xl font-bold text-amber-600 dark:text-amber-500 opacity-90">404</h1>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-stone-800 dark:text-stone-100 mb-3">
                    Oops! Halaman Tidak Ditemukan
                </h2>
                <p class="text-lg text-stone-600 dark:text-stone-400 mb-2">
                    Sepertinya halaman yang Anda cari sedang istirahat kopi ☕
                </p>
                <p class="text-stone-500 dark:text-stone-500">
                    Halaman ini mungkin telah dipindahkan, dihapus, atau tidak pernah ada.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="javascript:history.back()" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-stone-200 hover:bg-stone-300 dark:bg-stone-800 dark:hover:bg-stone-700 text-stone-700 dark:text-stone-200 font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
                
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ke Beranda
                </a>
            </div>

            <!-- Quick Links -->
            <div class="mt-12 pt-8 border-t border-stone-200 dark:border-stone-800">
                <p class="text-sm text-stone-500 dark:text-stone-400 mb-4">Atau kunjungi halaman lain:</p>
                <div class="flex flex-wrap gap-3 justify-center">
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-medium">
                                Dashboard Admin
                            </a>
                        @elseif(auth()->user()->hasRole('kasir'))
                            <a href="{{ route('cashier.dashboard') }}" class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-medium">
                                Dashboard Kasir
                            </a>
                        @elseif(auth()->user()->hasRole('barista'))
                            <a href="{{ route('barista.dashboard') }}" class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-medium">
                                Dashboard Barista
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-medium">
                            Login
                        </a>
                    @endauth
                    <span class="text-stone-300 dark:text-stone-700">•</span>
                    <a href="{{ route('location') }}" class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-medium">
                        Lokasi
                    </a>
                    <span class="text-stone-300 dark:text-stone-700">•</span>
                    <a href="{{ route('ourstory') }}" class="text-sm text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-medium">
                        Cerita Kami
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8">
                <p class="text-xs text-stone-400 dark:text-stone-600">
                    Error Code: 404 | Calping POS System
                </p>
            </div>
        </div>
    </div>
</body>
</html>
