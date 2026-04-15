@extends('layouts.customer')
@section('title', 'Menu Calping')

@section('content')
<!-- Categories (Sticky) -->
<div class="bg-coffee-200 border-b-2 border-coffee-900 py-6 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-3 gap-2 md:flex md:flex-nowrap md:overflow-x-auto md:gap-4 no-scrollbar items-center">
            <button onclick="filterCategory('all', this)" class="category-pill active w-full whitespace-nowrap px-2 sm:px-6 py-2 border-2 border-coffee-900 bg-coffee-900 text-white font-bold text-[9px] sm:text-xs uppercase tracking-widest shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-0.5 transition-all">
                Semua
            </button>
            @foreach($categories as $category)
                <button onclick="filterCategory('{{ $category->id }}', this)" class="category-pill w-full whitespace-nowrap px-2 sm:px-6 py-2 border-2 border-coffee-900 bg-white text-coffee-900 font-bold text-[9px] sm:text-xs uppercase tracking-widest shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:bg-cream-50 hover:-translate-y-0.5 transition-all">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>
</div>

@if(!session('table_id'))
<div class="bg-tuku-mustard/10 border-b border-tuku-mustard/20 py-3">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-tuku-mustard text-white flex items-center justify-center animate-pulse">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <p class="text-xs font-bold text-coffee-900 uppercase tracking-widest">Silakan pilih meja terlebih dahulu untuk memesan</p>
        </div>
        <a href="{{ route('customer.scan') }}" class="px-4 py-1.5 bg-coffee-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-full hover:bg-black transition-colors">
            Pilih Meja
        </a>
    </div>
</div>
@endif

<!-- Menu Grid -->
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-12 lg:gap-16">
        @foreach($categories as $category)
            @foreach($category->menus as $index => $menu)
                @php 
                    $rotation = ($index % 3 == 0) ? '-rotate-1' : (($index % 3 == 1) ? 'rotate-1' : 'rotate-2');
                    $hoverRotation = ($index % 3 == 0) ? 'rotate-0' : (($index % 3 == 1) ? '-rotate-1' : 'rotate-0');
                @endphp
                <div class="menu-card group relative" data-category="{{ $category->id }}">
                    <!-- Poster Style Card -->
                    <div class="bg-white border-2 border-coffee-900 p-2 md:p-4 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] md:shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] transition-all duration-300 group-hover:shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] md:group-hover:shadow-[16px_16px_0px_0px_rgba(43,30,22,1)] group-hover:-translate-y-2 {{ $rotation }} group-hover:{{ $hoverRotation }} flex flex-col h-full">
                        
                        <!-- Image Container -->
                        <div class="w-full overflow-hidden bg-coffee-100 border-2 border-coffee-900 mb-3 md:mb-6 relative" style="aspect-ratio: 4/5;">
                            @if($menu->image)
                                @php
                                    $imagePath = $menu->image;
                                    if (!Str::startsWith($imagePath, 'http') && !Str::startsWith($imagePath, 'img/')) {
                                        $imagePath = 'storage/' . $imagePath;
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-coffee-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            
                            <!-- Category Badge (Sticker) -->
                            <div class="absolute top-2 left-2 bg-coffee-900 text-white text-[10px] font-bold px-2 py-0.5 rounded-sm -rotate-3 border border-white/20">
                                {{ $category->name }}
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="flex-grow space-y-2 sm:space-y-3">
                            <div class="flex justify-between items-start">
                                <h3 class="text-sm sm:text-2xl font-bold text-coffee-900 font-heading leading-tight">{{ $menu->name }}</h3>
                            </div>
                            <p class="text-coffee-700 font-mono text-[9px] sm:text-[11px] leading-relaxed line-clamp-2 md:line-clamp-3">
                                {{ $menu->description ?? 'Racikan spesial dari barista Calping untuk menyegarkan harimu.' }}
                            </p>
                        </div>

                        <!-- Pricing and Controls Area -->
                        <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t-2 border-dotted border-coffee-900/30 flex justify-between items-center">
                            <div class="text-sm sm:text-lg font-bold text-coffee-900 font-mono">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </div>

                            <!-- Order Controls -->
                            <div class="flex items-center gap-1.5 sm:gap-3">
                                <button onclick="updateQuantity({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, -1)" 
                                        class="qty-minus-btn hidden w-7 h-7 sm:w-8 sm:h-8 items-center justify-center bg-white border-2 border-coffee-900 text-coffee-900 rounded-full hover:bg-cream-100 active:scale-90 transition-all shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]"
                                        data-id="{{ $menu->id }}">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                                </button>
                                <span class="qty-display hidden font-bold text-coffee-900 font-mono text-xs sm:text-base" data-id="{{ $menu->id }}">0</span>
                                <button onclick="updateQuantity({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, 1)" 
                                        class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-coffee-900 text-white rounded-full border-2 border-coffee-900 hover:scale-110 active:scale-90 transition-all shadow-[3px_3px_0px_0px_rgba(43,30,22,1)] sm:shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]">
                                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>

<!-- Redesigned Bottom Cart Bar -->
<div id="bottomCart" class="fixed -bottom-32 left-1/2 transform -translate-x-1/2 w-full max-w-sm px-4 z-[999] opacity-0 pointer-events-none transition-all duration-500">
    <button onclick="window.location.href='{{ route('customer.cart') }}'" class="w-full bg-coffee-900 border-2 border-coffee-900 p-4 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] flex justify-between items-center group active:translate-y-1 active:shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white border-2 border-coffee-900 flex items-center justify-center text-coffee-900 font-bold text-lg rotate-3" id="cartCountBadge">0</div>
            <div class="text-left">
                <p class="text-[10px] text-white/70 uppercase tracking-widest font-bold font-mono">Total Bayar</p>
                <p class="font-bold text-xl text-white font-mono" id="cartTotal">Rp 0</p>
            </div>
        </div>
        <div class="flex items-center gap-2 font-bold text-white uppercase text-xs tracking-widest">
            Lihat Keranjang
            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
    </button>
</div>

@push('scripts')
<script>
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    function updateCartUI() {
        const totalItems = Object.values(cart).reduce((a, b) => a + b.quantity, 0);
        const totalPrice = Object.values(cart).reduce((a, b) => a + (b.price * b.quantity), 0);
        
        const cartEl = document.getElementById('bottomCart');
        const badgeEl = document.getElementById('cartCountBadge');
        const totalEl = document.getElementById('cartTotal');
        
        if (totalItems > 0) {
            cartEl.classList.remove('opacity-0', 'pointer-events-none', '-bottom-32');
            cartEl.classList.add('opacity-100', 'bottom-8');
            badgeEl.textContent = totalItems;
            totalEl.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        } else {
            cartEl.classList.add('opacity-0', 'pointer-events-none', '-bottom-32');
            cartEl.classList.remove('opacity-100', 'bottom-8');
        }

        // Reset all controls first
        document.querySelectorAll('.qty-minus-btn').forEach(el => el.classList.add('hidden', 'flex'));
        document.querySelectorAll('.qty-minus-btn').forEach(el => el.classList.remove('flex'));
        document.querySelectorAll('.qty-display').forEach(el => el.classList.add('hidden'));

        // Update specific items
        for (const [id, item] of Object.entries(cart)) {
            if (item.quantity > 0) {
                // Better selector:
                const minusBtns = document.querySelectorAll(`.qty-minus-btn[data-id="${id}"]`);
                const displays = document.querySelectorAll(`.qty-display[data-id="${id}"]`);
                
                minusBtns.forEach(btn => {
                   btn.classList.remove('hidden');
                   btn.classList.add('flex');
                });
                displays.forEach(disp => {
                    disp.classList.remove('hidden');
                    disp.textContent = item.quantity;
                });
            }
        }
    }

    function updateQuantity(id, name, price, change) {
        if (!cart[id]) {
            cart[id] = { id, name, price, quantity: 0 };
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
            p.classList.remove('bg-coffee-900', 'text-white', 'shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]', '-translate-y-0.5');
            p.classList.add('bg-white', 'text-coffee-900');
        });
        
        // Apply Active Style to CLICKED pill
        btn.classList.add('bg-coffee-900', 'text-white', 'shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]', '-translate-y-0.5');
        btn.classList.remove('bg-white', 'text-coffee-900');

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
