@extends('layouts.customer')
@section('title', 'Menu - Calping Coffee')

@section('content')
<!-- Sticky Header (Search + Categories) -->
<div id="stickyHeader" class="bg-white border-b border-stone-100 sticky top-16 md:top-20 z-30 transition-transform duration-300 will-change-transform">
    <div class="max-w-7xl mx-auto px-4 md:px-6 pt-4 pb-2">
        <!-- Search Bar -->
        <div class="relative group mb-4">
            <input type="text" id="menuSearch" onkeyup="searchMenu()" placeholder="Cari menu favoritmu..." 
                   class="w-full bg-stone-50 border-none rounded-2xl py-3.5 pl-12 pr-4 text-sm font-medium placeholder:text-stone-400 focus:ring-2 focus:ring-stone-900/5 focus:bg-white transition-all shadow-sm">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 group-focus-within:text-stone-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Categories -->
        <div class="relative">
            <div class="flex overflow-x-auto gap-2 no-scrollbar items-center pb-2 -mx-4 px-4 md:mx-0 md:px-0">
                <button onclick="filterCategory('all', this)" class="category-pill active shrink-0 px-5 md:px-8 py-2 rounded-full bg-stone-900 text-white text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] transition-all active:scale-95 shadow-md truncate">
                    Semua
                </button>
                @foreach($categories as $category)
                    <button onclick="filterCategory('{{ $category->id }}', this)" class="category-pill shrink-0 px-5 md:px-8 py-2 rounded-full bg-stone-50 text-stone-500 text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] transition-all hover:bg-stone-900 hover:text-white active:scale-95 truncate">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

@if(!session('table_id'))
<div class="bg-stone-900 py-4">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-white/10 text-white flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <p class="text-xs font-bold text-white uppercase tracking-widest leading-relaxed">Pilih meja terlebih dahulu untuk memesan</p>
        </div>
        <a href="{{ route('customer.scan') }}" class="px-8 py-2.5 bg-white text-stone-900 text-[10px] font-bold uppercase tracking-widest rounded-full hover:bg-stone-100 transition-colors">
            Pilih Meja Sekarang
        </a>
    </div>
</div>
@endif

<!-- Menu Grid -->
<div class="py-8 md:py-16 max-w-7xl mx-auto px-4 md:px-10">
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-14">
        @foreach($categories as $category)
            @foreach($category->menus as $index => $menu)
                <div class="menu-card group" data-category="{{ $category->id }}">
                    <!-- Product Card -->
                    <div class="bg-white rounded-2xl md:rounded-[32px] p-3 md:p-4 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)] flex flex-col h-full border border-stone-50">
                        
                        <!-- Image Container -->
                        <div class="w-full overflow-hidden bg-stone-50 rounded-xl md:rounded-[24px] mb-3 md:mb-6 relative aspect-square">
                            @if($menu->image)
                                @php
                                    $imagePath = $menu->image;
                                    if (!Str::startsWith($imagePath, 'http') && !Str::startsWith($imagePath, 'img/')) {
                                        $imagePath = 'storage/' . $imagePath;
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-stone-200">
                                    <svg class="w-12 h-12 md:w-16 md:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            <div class="absolute top-2 left-2 md:top-4 md:left-4 bg-white/80 backdrop-blur-md text-stone-900 text-[7px] md:text-[9px] font-bold px-2 md:px-3 py-1 rounded-full uppercase tracking-widest border border-white/20">
                                {{ $category->name }}
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="flex-grow px-1 md:px-2 space-y-1 md:space-y-3">
                            <h3 class="text-base md:text-3xl font-bold text-stone-900 font-heading uppercase tracking-tight group-hover:text-stone-600 transition-colors line-clamp-1 md:line-clamp-none">{{ $menu->name }}</h3>
                            <p class="text-stone-400 text-[10px] md:text-xs leading-relaxed line-clamp-2 font-medium">
                                {{ $menu->description ?? 'Racikan spesial dari barista Calping untuk menyegarkan harimu.' }}
                            </p>
                        </div>

                        <!-- Pricing and Controls Area -->
                        <div class="mt-4 md:mt-8 px-1 md:px-2 pb-1 flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                            <div class="text-sm md:text-xl font-bold text-stone-900">
                                <span class="text-[8px] md:text-[10px] text-stone-400 uppercase tracking-widest mr-1">IDR</span>{{ number_format($menu->price, 0, ',', '.') }}
                            </div>
 
                            <!-- Order Controls -->
                            <div class="flex items-center justify-between md:justify-end gap-2 md:gap-3">
                                <button onclick="updateQuantity({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, -1, '{{ asset($imagePath) }}')" 
                                        class="qty-minus-btn hidden w-8 h-8 md:w-10 md:h-10 items-center justify-center bg-stone-50 text-stone-900 rounded-full hover:bg-stone-100 active:scale-90 transition-all border border-stone-100"
                                        data-id="{{ $menu->id }}">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                </button>
                                <span class="qty-display hidden font-bold text-stone-900 text-xs md:text-sm w-4 text-center" data-id="{{ $menu->id }}">0</span>
                                <button onclick="updateQuantity({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, 1, '{{ asset($imagePath) }}')" 
                                        class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-stone-900 text-white rounded-full transition-all hover:bg-stone-800 hover:scale-110 active:scale-95 shadow-lg shadow-stone-200">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>

<!-- Sleek Bottom Cart Bar -->
<div id="bottomCart" class="fixed bottom-0 left-0 w-full pt-16 pb-6 px-6 z-[100] transform translate-y-full opacity-0 pointer-events-none transition-all duration-700 ease-out bg-gradient-to-t from-white via-white/90 to-transparent">
    <div class="max-w-xl mx-auto">
        <button onclick="window.location.href='{{ route('customer.cart') }}'" class="w-full bg-stone-900 text-white p-5 rounded-[24px] shadow-2xl flex justify-between items-center group active:scale-95 transition-all">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-white font-bold text-xl" id="cartCountBadge">0</div>
                <div class="text-left">
                    <p class="text-[10px] text-white/40 uppercase tracking-[0.2em] font-bold mb-1">Total Pesanan</p>
                    <p class="font-bold text-2xl" id="cartTotal">Rp 0</p>
                </div>
            </div>
            <div class="flex items-center gap-3 px-6 py-3 bg-white text-stone-900 rounded-full font-bold text-[10px] uppercase tracking-widest group-hover:gap-5 transition-all">
                <span>Konfirmasi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </div>
        </button>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Menu Card Reveal Animation
        gsap.from(".menu-card", {
            y: 40,
            opacity: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: "power3.out"
        });
    });

    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    function updateCartUI() {
        const totalItems = Object.values(cart).reduce((a, b) => a + b.quantity, 0);
        const totalPrice = Object.values(cart).reduce((a, b) => a + (b.price * b.quantity), 0);
        
        const cartEl = document.getElementById('bottomCart');
        const badgeEl = document.getElementById('cartCountBadge');
        const totalEl = document.getElementById('cartTotal');
        
        if (totalItems > 0) {
            cartEl.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');
            badgeEl.textContent = totalItems;
            totalEl.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        } else {
            cartEl.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');
        }

        // Reset all controls first
        document.querySelectorAll('.qty-minus-btn').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.qty-display').forEach(el => el.classList.add('hidden'));

        // Update specific items
        for (const [id, item] of Object.entries(cart)) {
            if (item.quantity > 0) {
                const minusBtns = document.querySelectorAll(`.qty-minus-btn[data-id="${id}"]`);
                const displays = document.querySelectorAll(`.qty-display[data-id="${id}"]`);
                
                minusBtns.forEach(btn => btn.classList.remove('hidden'));
                displays.forEach(disp => {
                    disp.classList.remove('hidden');
                    disp.textContent = item.quantity;
                });
            }
        }
    }

    function updateQuantity(id, name, price, change, image) {
        if (!cart[id]) {
            cart[id] = { id, name, price, image, quantity: 0 };
        }
        
        cart[id].quantity += change;
        
        if (cart[id].quantity <= 0) {
            delete cart[id];
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    }

    // Optimized Scroll Handler for Mobile
    let lastScrollTop = 0;
    let ticking = false;
    const stickyHeader = document.getElementById('stickyHeader');
    
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                let scrollTop = window.scrollY || document.documentElement.scrollTop;
                
                // Force show at the top of the page
                if (scrollTop < 50) {
                    stickyHeader.style.transform = 'translateY(0)';
                } 
                else if (Math.abs(lastScrollTop - scrollTop) > 10) { // Add threshold to avoid jumpiness
                    if (scrollTop > lastScrollTop && scrollTop > 150) {
                        // Scroll Down - Hide
                        stickyHeader.style.transform = 'translateY(-110%)';
                    } else if (scrollTop < lastScrollTop) {
                        // Scroll Up - Show
                        stickyHeader.style.transform = 'translateY(0)';
                    }
                    lastScrollTop = scrollTop;
                }
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    function searchMenu() {
        const query = document.getElementById('menuSearch').value.toLowerCase();
        const cards = document.querySelectorAll('.menu-card');
        
        cards.forEach(card => {
            const name = card.querySelector('h3').textContent.toLowerCase();
            const desc = card.querySelector('p').textContent.toLowerCase();
            
            if (name.includes(query) || desc.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function filterCategory(catId, btn) {
        // Clear search when filtering by category
        document.getElementById('menuSearch').value = '';
        
        // Reset styles for ALL pills
        document.querySelectorAll('.category-pill').forEach(p => {
            p.classList.remove('bg-stone-900', 'text-white', 'shadow-md');
            p.classList.add('bg-stone-50', 'text-stone-500');
        });
        
        // Apply Active Style to CLICKED pill
        btn.classList.add('bg-stone-900', 'text-white', 'shadow-md');
        btn.classList.remove('bg-stone-50', 'text-stone-500');

        // Filter items
        const cards = document.querySelectorAll('.menu-card');
        cards.forEach(card => {
            if (catId === 'all' || card.dataset.category === catId) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Init
    updateCartUI();
</script>
@endpush
@endsection
