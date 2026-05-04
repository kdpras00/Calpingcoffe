<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Calping Coffee</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Bebas+Neue&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/calpinglogoico-removebg-preview.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-stone-50 text-stone-900" 
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
             class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm z-40 lg:hidden"
             @click="mobileMenu = false"
             style="display: none;"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 bg-stone-950 text-white transition-all duration-500 ease-in-out border-r border-white/5 flex flex-col"
               :class="{
                   'translate-x-0 w-72': !isMobile && sidebarOpen,
                   'translate-x-0 w-24': !isMobile && !sidebarOpen,
                   'translate-x-0 w-80': isMobile && mobileMenu,
                   '-translate-x-full w-80': isMobile && !mobileMenu
               }">
            
            <!-- Logo -->
            <div class="h-20 flex items-center border-b border-white/5 transition-all duration-300 px-6"
                 :class="(!isMobile && !sidebarOpen) ? 'justify-center !px-0' : ''">
                <div class="flex items-center gap-4 w-full overflow-hidden">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shrink-0">
                        <span class="text-stone-950 font-black text-xl">C</span>
                    </div>
                    <span class="font-heading font-black text-2xl text-white whitespace-nowrap transition-all duration-300 uppercase tracking-tight"
                          :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">
                        CALPING COFFEE
                    </span>
                    <!-- Mobile Close Button -->
                    <button @click="mobileMenu = false" 
                            x-show="isMobile && mobileMenu"
                            class="text-white ml-auto shrink-0 transition-transform hover:rotate-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2 no-scrollbar">
                @php
                    $role = Auth::user()->role;
                    $routePrefix = $role === 'kasir' ? 'cashier' : $role;
                @endphp

                <a href="{{ route($routePrefix . '.dashboard') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group {{ request()->routeIs($routePrefix . '.dashboard') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]"
                          :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">
                        Dashboard
                    </span>
                </a>

                @if($role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group {{ request()->routeIs('admin.users.*') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">Pengguna</span>
                    </a>
                    <a href="{{ route('admin.tables.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group {{ request()->routeIs('admin.tables.*') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">Meja</span>
                    </a>
                    <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group {{ request()->routeIs('admin.menus.*') ? 'bg-white text-stone-900 shadow-xl' : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]" 
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">Menu</span>
                    </a>
                @endif
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-red-400 hover:bg-red-500/10 transition-all group">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="whitespace-nowrap overflow-hidden transition-all duration-300 font-bold text-[10px] uppercase tracking-[0.2em]"
                              :class="(isMobile && mobileMenu) || (!isMobile && sidebarOpen) ? 'opacity-100 max-w-xs' : 'opacity-0 max-w-0'">
                            Log Out
                        </span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="min-h-screen transition-all duration-500 ease-in-out"
             :class="{
                 'ml-72': !isMobile && sidebarOpen,
                 'ml-24': !isMobile && !sidebarOpen,
                 'ml-0': isMobile
             }">
            
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
