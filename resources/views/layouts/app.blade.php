<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Calping</title>

    <!-- Tuku-Exact Fonts: DM Mono & Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Nunito:wght@400;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/calpinglogoico-removebg-preview.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'DM Mono', monospace; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Quicksand', sans-serif; letter-spacing: -0.02em; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-coffee-200 text-coffee-900 dark:bg-stone-950 dark:text-stone-100" 
      x-data="{
          isMobile: window.innerWidth < 1024,
          sidebarOpen: window.innerWidth >= 1024,
          mobileMenu: false,
          init() {
              window.addEventListener('resize', () => {
                  this.isMobile = window.innerWidth < 1024;
                  if (!this.isMobile) {
                      this.mobileMenu = false;
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
             class="fixed inset-0 bg-coffee-900/60 backdrop-blur-sm z-40 lg:hidden"
             @click="mobileMenu = false"
             style="display: none;"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 bg-coffee-900 text-white transition-all duration-300 ease-in-out border-r-4 border-coffee-900 flex flex-col"
               :class="{
                   'translate-x-0 w-64': !isMobile && sidebarOpen,
                   'translate-x-0 w-20': !isMobile && !sidebarOpen,
                   'translate-x-0 w-72': isMobile && mobileMenu,
                   '-translate-x-full w-72': isMobile && !mobileMenu
               }">
            
            <!-- Logo -->
            <div class="h-16 flex items-center border-b-2 border-white/10 transition-all duration-300 px-5"
                 :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                <div class="flex items-center gap-3 w-full">
                    <span class="font-heading font-black text-lg text-white whitespace-nowrap overflow-hidden transition-all duration-300 uppercase tracking-tighter"
                          :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">
                        CALPINGCOFFEE
                    </span>
                    <!-- Mobile Close Button -->
                    <button @click="mobileMenu = false" 
                            x-show="isMobile && mobileMenu"
                            class="text-white ml-auto shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @php
                    $role = Auth::user()->role;
                    $routePrefix = $role === 'kasir' ? 'cashier' : $role;
                @endphp

                <a href="{{ route($routePrefix . '.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-3 border-2 transition-all group {{ request()->routeIs($routePrefix . '.dashboard') ? 'bg-tuku-mustard text-coffee-900 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]' : 'border-transparent text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-xs uppercase tracking-widest"
                          :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">
                        Dashboard
                    </span>
                </a>

                @if($role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-3 border-2 transition-all group {{ request()->routeIs('admin.users.*') ? 'bg-tuku-mustard text-coffee-900 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]' : 'border-transparent text-stone-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-xs uppercase tracking-widest" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">Pengguna</span>
                    </a>
                    <a href="{{ route('admin.tables.index') }}" class="flex items-center gap-3 px-3 py-3 border-2 transition-all group {{ request()->routeIs('admin.tables.*') ? 'bg-tuku-mustard text-coffee-900 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]' : 'border-transparent text-stone-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-xs uppercase tracking-widest" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">Meja</span>
                    </a>
                    <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-3 py-3 border-2 transition-all group {{ request()->routeIs('admin.menus.*') ? 'bg-tuku-mustard text-coffee-900 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]' : 'border-transparent text-stone-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-xs uppercase tracking-widest" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">Menu</span>
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="min-h-screen transition-all duration-300 ease-in-out"
             :class="{
                 'ml-64': !isMobile && sidebarOpen,
                 'ml-20': !isMobile && !sidebarOpen,
                 'ml-0': isMobile
             }">
            
            <!-- Top Bar -->
            <header class="bg-white dark:bg-stone-900 border-b-4 border-coffee-900 h-16 flex items-center justify-between px-4 sticky top-0 z-30">
                <button @click="isMobile ? mobileMenu = !mobileMenu : sidebarOpen = !sidebarOpen" 
                        class="text-coffee-900 hover:scale-110 transition-transform focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <div class="flex items-center gap-4">
                    <span class="text-xs font-mono font-bold uppercase tracking-widest text-coffee-600 hidden md:block">{{ now()->format('l, d M Y') }}</span>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none">
                            <div class="w-10 h-10 rounded-none bg-white border-2 border-coffee-900 flex items-center justify-center text-coffee-900 font-bold text-sm shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-stone-900 rounded-md shadow-md border border-stone-200 dark:border-stone-700 py-1 z-50"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-stone-100 dark:border-stone-800">
                                <p class="text-sm font-bold text-stone-800 dark:text-stone-100">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-stone-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
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
        // SweetAlert2 Toast Configuration
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

        // Show success message
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        // Show error message
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Confirm delete function
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
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
