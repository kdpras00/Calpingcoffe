@extends('layouts.customer')
@section('title', 'Menu - Calping Coffee')

@section('content')
<!-- Categories (Sticky) -->
<div class="bg-white border-b border-stone-100 py-6 sticky top-20 z-30">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex overflow-x-auto gap-3 no-scrollbar items-center pb-2">
            <button onclick="filterCategory('all', this)" class="category-pill active whitespace-nowrap px-8 py-2.5 rounded-full bg-stone-900 text-white text-[10px] font-bold uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-lg">
                Semua
            </button>
            @foreach($categories as $category)
                <button onclick="filterCategory('{{ $category->id }}', this)" class="category-pill whitespace-nowrap px-8 py-2.5 rounded-full bg-stone-50 text-stone-500 text-[10px] font-bold uppercase tracking-[0.2em] transition-all hover:bg-stone-100 hover:text-stone-900 active:scale-95">
                    {{ $category->name }}
                </button>
            @endforeach
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
<div class="py-16 max-w-7xl mx-auto px-6 sm:px-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-14">
        @foreach($categories as $category)
            @foreach($category->menus as $index => $menu)
                <div class="menu-card group" data-category="{{ $category->id }}">
                    <!-- Product Card -->
                    <div class="bg-white rounded-[32px] p-4 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)] flex flex-col h-full border border-stone-50">
                        
                        <!-- Image Container -->
                        <div class="w-full overflow-hidden bg-stone-50 rounded-[24px] mb-6 relative aspect-square">
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
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4 bg-white/80 backdrop-blur-md text-stone-900 text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-white/20">
                                {{ $category->name }}
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="flex-grow px-2 space-y-3">
                            <h3 class="text-3xl font-bold text-stone-900 font-heading uppercase tracking-tight group-hover:text-stone-600 transition-colors">{{ $menu->name }}</h3>
                            <p class="text-stone-400 text-xs leading-relaxed line-clamp-2 font-medium">
                                {{ $menu->description ?? 'Racikan spesial dari barista Calping untuk menyegarkan harimu.' }}
                            </p>
                        </div>

                        <!-- Pricing and Controls Area -->
                        <div class="mt-8 px-2 pb-2 flex justify-between items-center">
                            <div class="text-xl font-bold text-stone-900">
                                <span class="text-[10px] text-stone-400 uppercase tracking-widest mr-1">IDR</span>{{ number_format($menu->price, 0, ',', '.') }}
                            </div>

                            <!-- Order Controls -->
                            <div class="flex items-center gap-3">
                                <button onclick="updateQuantity({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, -1, '{{ asset($imagePath) }}')" 
                                        class="qty-minus-btn hidden w-10 h-10 items-center justify-center bg-stone-50 text-stone-900 rounded-full hover:bg-stone-100 active:scale-90 transition-all border border-stone-100"
                                        data-id="{{ $menu->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                </button>
                                <span class="qty-display hidden font-bold text-stone-900 text-sm w-4 text-center" data-id="{{ $menu->id }}">0</span>
                                <button onclick="updateQuantity({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, 1, '{{ asset($imagePath) }}')" 
                                        class="w-12 h-12 flex items-center justify-center bg-stone-900 text-white rounded-full transition-all hover:bg-stone-800 hover:scale-110 active:scale-95 shadow-lg shadow-stone-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
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

    function filterCategory(catId, btn) {
        // Reset styles for ALL pills
        document.querySelectorAll('.category-pill').forEach(p => {
            p.classList.remove('bg-stone-900', 'text-white', 'shadow-lg', 'scale-105');
            p.classList.add('bg-stone-50', 'text-stone-500');
        });
        
        // Apply Active Style to CLICKED pill
        btn.classList.add('bg-stone-900', 'text-white', 'shadow-lg', 'scale-105');
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
