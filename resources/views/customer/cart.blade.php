@extends('layouts.customer')

@section('title', 'Keranjang Pesanan')

@section('content')
<div class="min-h-screen bg-stone-50 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Error/Success Messages -->
        @if(session('error'))
            <div class="mb-8 p-6 bg-red-50 border border-red-100 rounded-[24px] flex items-center gap-4 animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <p class="text-xs font-bold text-red-900 uppercase tracking-widest">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-8 p-6 bg-green-50 border border-green-100 rounded-[24px] flex items-center gap-4 animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-widest">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('customer.index') }}" class="group flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-stone-200 text-stone-900 hover:bg-stone-900 hover:text-white transition-all duration-500 shadow-sm">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Review Pesanan</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold font-heading text-stone-900 uppercase tracking-tight">Keranjang Anda</h1>
            </div>
            
            @if(session('table_number'))
            <div class="flex items-center gap-4 bg-stone-900 px-6 py-4 rounded-2xl shadow-lg shadow-stone-200">
                <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Nomor Meja</span>
                <span class="text-xl font-bold text-white font-heading">{{ session('table_number') }}</span>
            </div>
            @endif
        </div>

        <!-- SPLIT LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- LEFT: CART ITEMS -->
            <div class="lg:col-span-7 space-y-8">
                <div id="cartItems" class="space-y-6">
                    <!-- Items injected here by JavaScript -->
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden py-32 flex flex-col items-center justify-center gap-8 bg-white rounded-[40px] border border-stone-100 shadow-sm">
                    <div class="w-24 h-24 rounded-full bg-stone-50 flex items-center justify-center text-stone-200">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-stone-900 font-heading uppercase tracking-widest mb-2">Keranjang Kosong</h3>
                        <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mb-8">Anda belum menambahkan menu apapun</p>
                        <a href="{{ route('customer.index') }}" class="inline-flex items-center gap-4 bg-stone-900 text-white px-8 py-4 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-stone-800 transition-all shadow-xl shadow-stone-200">
                            Lihat Menu
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT: CHECKOUT -->
            <div class="lg:col-span-5 lg:sticky lg:top-24">
                <div id="checkoutContainer" class="hidden space-y-10 transition-all duration-700 bg-white p-8 md:p-10 rounded-[40px] border border-stone-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
                    <!-- Summary Card -->
                    <div id="orderSummary" class="">
                        <h2 class="text-xl font-heading font-bold text-stone-900 uppercase tracking-widest mb-10 pb-6 border-b border-stone-100">Ringkasan Pembayaran</h2>
                        
                        <div class="space-y-6">
                            <div class="flex justify-between items-center text-stone-500">
                                <span class="text-xs font-bold uppercase tracking-widest">Subtotal</span>
                                <span id="subtotal" class="font-bold text-stone-900 tracking-tight">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center text-stone-500">
                                <span class="text-xs font-bold uppercase tracking-widest">Pajak (10%)</span>
                                <span id="tax" class="font-bold text-stone-900 tracking-tight">Rp 0</span>
                            </div>
                            
                            <div class="pt-8 mt-4 border-t border-stone-100">
                                <div class="flex justify-between items-end">
                                    <span class="text-xs font-bold text-stone-400 uppercase tracking-[0.3em]">Total Bayar</span>
                                    <span id="total" class="text-5xl font-bold font-heading text-stone-900 tracking-tighter">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <form id="checkoutForm" action="{{ route('customer.checkout') }}" method="POST" class="space-y-8 pt-8 border-t border-stone-100">
                        @csrf
                        <input type="hidden" name="items" id="itemsInput">
                        
                        @if(!session('table_number'))
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-0.5 bg-stone-900"></div>
                                <label for="table_number" class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.4em]">Pilih Nomor Meja</label>
                            </div>
                            <div class="relative">
                                <select name="table_number" id="table_number" required
                                    class="w-full rounded-[32px] border-stone-200 bg-stone-50 text-stone-900 focus:ring-stone-900 focus:border-stone-900 transition-all p-6 font-bold text-sm appearance-none cursor-pointer">
                                    <option value="" disabled selected>-- Pilih Meja Anda --</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->number }}" {{ $table->is_occupied ? 'disabled' : '' }}>
                                            Meja {{ $table->number }} {{ $table->is_occupied ? '(Penuh)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-8 flex items-center text-stone-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-0.5 bg-stone-900"></div>
                                <label for="note" class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.4em]">Instruksi Khusus</label>
                            </div>
                            <textarea name="note" id="note" rows="3" 
                                class="w-full rounded-[32px] border-stone-200 bg-stone-50 text-stone-900 placeholder-stone-300 focus:ring-stone-900 focus:border-stone-900 transition-all resize-none p-6 font-medium text-sm"
                                placeholder="Contoh: Es dipisah, gula sedikit..."></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-stone-900 text-white font-bold py-6 px-10 rounded-[32px] shadow-2xl shadow-stone-300 hover:bg-stone-800 active:scale-[0.98] transition-all flex items-center justify-center gap-6 group">
                                <span class="uppercase tracking-[0.2em] text-xs">Pesan Sekarang</span>
                                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:translate-x-2 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    function renderCart() {
        const container = document.getElementById('cartItems');
        const checkoutContainer = document.getElementById('checkoutContainer');
        const emptyState = document.getElementById('emptyState');
        
        container.innerHTML = '';
        
        if (Object.keys(cart).length === 0) {
            emptyState.classList.remove('hidden');
            checkoutContainer.classList.add('hidden');
            updateTotals();
            return;
        }

        emptyState.classList.add('hidden');
        checkoutContainer.classList.remove('hidden');

        for (const [id, item] of Object.entries(cart)) {
            const itemElement = document.createElement('div');
            itemElement.className = 'bg-white rounded-[32px] p-6 border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col md:flex-row items-center justify-between gap-6 group';
            
            const imageHtml = item.image 
                ? `<img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">`
                : `<div class="w-full h-full flex items-center justify-center text-stone-200 bg-stone-50">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                   </div>`;

            itemElement.innerHTML = `
                <div class="flex items-center gap-6 w-full md:w-auto">
                    <div class="w-20 h-20 bg-stone-100 rounded-2xl overflow-hidden border border-stone-50 shrink-0">
                        ${imageHtml}
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-stone-900 uppercase tracking-tight text-xl mb-1">${item.name}</h3>
                        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em]">IDR ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between w-full md:w-auto gap-12">
                    <div class="flex items-center gap-6 bg-stone-50 px-6 py-3 rounded-2xl border border-stone-100">
                        <button onclick="updateQuantity(${id}, -1)" class="text-stone-400 hover:text-stone-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                        </button>
                        <span class="text-sm font-bold text-stone-900 w-4 text-center">${item.quantity}</span>
                        <button onclick="updateQuantity(${id}, 1)" class="text-stone-400 hover:text-stone-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-stone-900 text-lg tracking-tight mb-2">IDR ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</p>
                        <button onclick="removeFromCart(${id})" class="text-[9px] font-bold text-red-400 hover:text-red-600 uppercase tracking-widest transition-colors flex items-center gap-2 ml-auto">
                            Hapus
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(itemElement);
        }
        updateTotals();
    }

    function updateQuantity(id, change) {
        if (cart[id]) {
            cart[id].quantity += change;
            if (cart[id].quantity <= 0) {
                delete cart[id];
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    function removeFromCart(id) {
        if (cart[id]) {
            delete cart[id];
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    function updateTotals() {
        const subtotal = Object.values(cart).reduce((a, b) => a + (b.price * b.quantity), 0);
        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        const subtotalEl = document.getElementById('subtotal');
        const taxEl = document.getElementById('tax');
        const totalEl = document.getElementById('total');

        if (subtotalEl) subtotalEl.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        if (taxEl) taxEl.textContent = `Rp ${tax.toLocaleString('id-ID')}`;
        if (totalEl) totalEl.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        
        const items = Object.values(cart).map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price
        }));
        
        const itemsInput = document.getElementById('itemsInput');
        if (itemsInput) itemsInput.value = JSON.stringify(items);
    }

    renderCart();
</script>
@endpush
@endsection
