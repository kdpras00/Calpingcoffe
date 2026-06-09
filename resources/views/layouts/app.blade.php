<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Calping Coffee</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- display=block: text invisible briefly while font loads, NO size jump (unlike swap which shows fallback font first) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Bebas+Neue&display=block" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/calpinglogoico-removebg-preview.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Set font immediately via inline style — no waiting for Tailwind or Google Fonts to apply */
        *, *::before, *::after { box-sizing: border-box; }
        html { font-size: 16px; line-height: 1.5; }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            font-size: 0.875rem;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Bebas Neue', ui-sans-serif, sans-serif;
            letter-spacing: 0.05em;
        }
        [x-cloak] { display: none !important; }
        
        /* Pre-Alpine Sidebar Collapsed States */
        html.sidebar-collapsed .sidebar-text {
            opacity: 0 !important;
            max-width: 0px !important;
            pointer-events: none !important;
        }
        html.sidebar-collapsed .sidebar-link {
            justify-content: center !important;
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    </style>

    {{-- Prevent layout shift & sidebar blink: apply sidebar state BEFORE Alpine.js initializes --}}
    <script>
        (function() {
            var isMobile = window.innerWidth < 1024;
            var stored = localStorage.getItem('sidebarOpen');
            var sidebarOpen = isMobile ? false : (stored === null ? true : stored === 'true');
            if (!isMobile) {
                document.documentElement.style.setProperty('--sidebar-width', sidebarOpen ? '18rem' : '6rem');
                document.documentElement.style.setProperty('--sidebar-translate', 'translateX(0)');
                document.documentElement.style.setProperty('--sidebar-margin', sidebarOpen ? '18rem' : '6rem');
                if (!sidebarOpen) document.documentElement.classList.add('sidebar-collapsed');
            } else {
                document.documentElement.style.setProperty('--sidebar-width', '20rem');
                document.documentElement.style.setProperty('--sidebar-translate', 'translateX(-100%)');
                document.documentElement.style.setProperty('--sidebar-margin', '0px');
            }
        })();
    </script>
</head>
<body class="antialiased bg-stone-50 text-stone-900" 
      x-data="{
          isMobile: window.innerWidth < 1024,
          sidebarOpen: window.innerWidth >= 1024
              ? (localStorage.getItem('sidebarOpen') === null ? true : localStorage.getItem('sidebarOpen') === 'true')
              : false,
          mobileMenu: false,
          init() {
              this.$watch('sidebarOpen', val => {
                  localStorage.setItem('sidebarOpen', val);
                  if (!this.isMobile) {
                      document.documentElement.style.setProperty('--sidebar-width', val ? '18rem' : '6rem');
                      document.documentElement.style.setProperty('--sidebar-margin', val ? '18rem' : '6rem');
                      if (!val) document.documentElement.classList.add('sidebar-collapsed');
                      else document.documentElement.classList.remove('sidebar-collapsed');
                  }
              });
              window.addEventListener('resize', () => {
                  this.isMobile = window.innerWidth < 1024;
                  if (!this.isMobile) {
                      this.mobileMenu = false;
                      document.documentElement.style.setProperty('--sidebar-width', this.sidebarOpen ? '18rem' : '6rem');
                      document.documentElement.style.setProperty('--sidebar-translate', 'translateX(0)');
                      document.documentElement.style.setProperty('--sidebar-margin', this.sidebarOpen ? '18rem' : '6rem');
                      if (!this.sidebarOpen) document.documentElement.classList.add('sidebar-collapsed');
                      else document.documentElement.classList.remove('sidebar-collapsed');
                  } else {
                      document.documentElement.style.setProperty('--sidebar-width', '20rem');
                      document.documentElement.style.setProperty('--sidebar-translate', 'translateX(-100%)');
                      document.documentElement.style.setProperty('--sidebar-margin', '0px');
                      document.documentElement.classList.remove('sidebar-collapsed');
                  }
              });
          }
      }">

    @auth
        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileMenu && isMobile" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm z-40 lg:hidden"
             @click="mobileMenu = false"
             style="display: none;"></div>

        <!-- Sidebar -->
        <aside id="main-sidebar"
               class="fixed inset-y-0 left-0 z-50 bg-stone-950 text-white border-r border-white/5 flex flex-col"
               style="width: var(--sidebar-width, 18rem); transform: var(--sidebar-translate, translateX(0));"
               x-init="$nextTick(() => { $el.style.transition = 'width 500ms ease-in-out, transform 500ms ease-in-out'; })"
               :style="{
                   width: isMobile ? '20rem' : (sidebarOpen ? '18rem' : '6rem'),
                   transform: isMobile ? (mobileMenu ? 'translateX(0)' : 'translateX(-100%)') : 'translateX(0)'
               }">
            
            <!-- Logo -->
            <div class="sidebar-link h-20 flex items-center border-b border-white/5 transition-all duration-300 px-6"
                 :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                <div class="flex items-center justify-center gap-4 w-full overflow-hidden relative">
                    <span class="sidebar-text font-heading font-black text-2xl text-white whitespace-nowrap transition-all duration-300 uppercase tracking-tight text-center"
                          :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">
                        CALPING COFFEE
                    </span>
                    <!-- Mobile Close Button (Positioned Absolute to not affect centering) -->
                    <button @click="mobileMenu = false" 
                            x-show="isMobile && mobileMenu"
                            style="display: none;"
                            class="text-white absolute right-0 shrink-0 transition-transform hover:rotate-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-3 no-scrollbar">
                @php
                    $role = Auth::user()->role;
                    $routePrefix = $role === 'kasir' ? 'cashier' : $role;
                @endphp

                <a href="{{ route($routePrefix . '.dashboard') }}" 
                   class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs($routePrefix . '.dashboard') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                   :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                    <div class="w-6 h-6 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]"
                          :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">
                        Dashboard
                    </span>
                </a>

                @if($role === 'kasir')
                    <a href="{{ route('cashier.transactions') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('cashier.transactions') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Transaksi Penjualan</span>
                    </a>
                    
                    <a href="{{ route('cashier.history') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('cashier.history') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Riwayat Penjualan</span>
                    </a>
                    <a href="{{ route('cashier.tables') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('cashier.tables') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Kelola Ketersediaan Meja</span>
                    </a>
                @endif

                @if($role === 'barista')
                    <a href="{{ route('barista.orders') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('barista.orders') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Kelola Pemesanan</span>
                    </a>
                    <a href="{{ route('barista.menus') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('barista.menus') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Kontrol Stok Menu</span>
                    </a>
                @endif

                @if($role === 'admin')
                    <a href="{{ route('admin.users.index') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.users.*') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Kelola Pengguna</span>
                    </a>
                    <a href="{{ route('admin.tables.index') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.tables.*') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Kelola Meja</span>
                    </a>
                    <a href="{{ route('admin.menus.index') }}" 
                       class="sidebar-link flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.menus.*') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}"
                       :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">Kelola Menu</span>
                    </a>
                @endif
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="sidebar-link w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-red-400 hover:bg-red-500/10 transition-all duration-300 group"
                            :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <span class="sidebar-text whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]"
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0 pointer-events-none'">
                            Log Out
                        </span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="min-h-screen transition-all duration-500 ease-in-out"
             style="margin-left: var(--sidebar-margin, 18rem)"
             :style="isMobile ? 'margin-left: 0' : (sidebarOpen ? 'margin-left: 18rem' : 'margin-left: 6rem')">
            
            <!-- Top Bar -->
            <header class="bg-white/80 backdrop-blur-md border-b border-stone-100 h-20 flex items-center justify-between px-8 sticky top-0 z-30">
                <button @click="isMobile ? mobileMenu = !mobileMenu : sidebarOpen = !sidebarOpen" 
                        class="p-2 text-stone-900 hover:bg-stone-50 rounded-xl transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <div class="flex items-center gap-6">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-stone-400 hidden md:block">{{ now()->format('l, d M Y') }}</span>
                    
                    <div class="h-8 w-px bg-stone-100 hidden md:block"></div>

                    <!-- User Profile -->
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-stone-900 uppercase tracking-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[9px] text-stone-400 font-bold uppercase tracking-widest">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-stone-900 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-stone-200">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8 md:p-12">
                @yield('content')
            </main>
        </div>
    @else
        <!-- Guest Layout (Login) -->
        <main class="min-h-screen">
            @yield('content')
        </main>
    @endauth

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0c0a09',
                cancelButtonColor: '#78716c',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                color: '#0c0a09',
                customClass: {
                    confirmButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest',
                    cancelButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
