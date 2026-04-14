@extends('layouts.customer')

@section('title', 'Pesanan Anda')

@section('content')
<div class="min-h-screen bg-coffee-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('customer.index') }}" class="group flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] border-2 border-coffee-900 text-coffee-900 hover:-translate-y-0.5 transition-all">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-3xl font-bold font-heading text-coffee-900 uppercase tracking-tighter">Pesanan Anda</h1>
            </div>
            @if(session('table_number'))
            <span class="text-xs font-bold text-white bg-coffee-900 px-4 py-1.5 rounded-full border-2 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] uppercase tracking-widest">
                Meja {{ session('table_number') }}
            </span>
            @endif
        </div>

        <div id="cartItems" class="space-y-6 mb-12">
            <!-- Items injected here -->
        </div>

        <!-- Order Summary (Poster Style) -->
        <div id="orderSummary" class="bg-white border-2 border-coffee-900 p-8 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] relative overflow-hidden -rotate-1">
            <div class="space-y-4 relative z-10">
                <h2 class="text-xl font-heading font-bold text-coffee-900 uppercase tracking-widest border-b-2 border-dotted border-coffee-900/30 pb-4 mb-6">Ringkasan Pembayaran</h2>
                
                <div class="flex justify-between items-center text-coffee-700 font-mono">
                    <span class="text-sm">Subtotal</span>
                    <span id="subtotal" class="font-bold text-coffee-900 text-base">Rp 0</span>
                </div>
                <div class="flex justify-between items-center text-coffee-700 font-mono">
                    <span class="text-sm">Pajak (10%)</span>
                    <span id="tax" class="font-bold text-coffee-900 text-base">Rp 0</span>
                </div>
                
                <div class="pt-6 mt-6 border-t-2 border-coffee-900">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-bold text-coffee-900 uppercase tracking-widest">Total Bayar</span>
                        <span id="total" class="text-4xl font-bold font-heading text-coffee-900 tracking-tighter">Rp 0</span>
                    </div>
                </div>
            </div>

            <div class="mt-12">
                <form id="checkoutForm" action="{{ route('customer.checkout') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="items" id="itemsInput">
                    
                    <div>
                        <label for="note" class="block text-xs font-bold text-coffee-900 uppercase tracking-widest mb-3">Catatan Pesanan (Stiker Tambahan)</label>
                        <div class="relative">
                            <textarea name="note" id="note" rows="3" 
                                class="w-full rounded-none border-2 border-coffee-900 bg-white text-coffee-900 placeholder-coffee-400 focus:ring-0 transition-all resize-none p-4 font-mono text-sm shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]"
                                placeholder="Contoh: Es dipisah, gula sedikit..."></textarea>
                        </div>
                    </div>

                    @if(session('table_number'))
                        <div class="mb-6 p-4 bg-stone-50 border border-stone-200 dark:bg-stone-800 dark:border-stone-700 rounded-lg flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] font-mono font-bold text-stone-500 uppercase tracking-widest mb-1">Lokasi Pesanan</span>
                                <span class="font-bold text-coffee-900 dark:text-coffee-300">Meja {{ session('table_number') }}</span>
                            </div>
                        </div>
                    @else
                        <!-- Fallback (should not be reached due to middleware/controller redirect) -->
                        <div>
                            <label for="table_number" class="block text-xs font-bold text-coffee-900 uppercase tracking-widest mb-3">Pilih Nomor Meja Anda</label>
                            <div class="relative">
                                <select name="table_number" id="table_number" required
                                    class="w-full rounded-none border-2 border-coffee-900 bg-white text-coffee-900 focus:ring-0 transition-all p-4 font-mono text-sm shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] appearance-none cursor-pointer">
                                    <option value="" disabled selected>-- Pilih Meja --</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->number }}" {{ $table->is_occupied ? 'disabled' : '' }}>
                                            Meja {{ $table->number }} {{ $table->is_occupied ? '(Terpakai)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-coffee-900">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="w-full bg-coffee-900 text-white font-bold py-5 px-8 border-2 border-coffee-900 shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] hover:shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 active:translate-y-1 active:shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] transition-all flex items-center justify-center gap-3 group uppercase tracking-widest text-sm">
                        <span>{{ session('table_id') ? 'Konfirmasi Pesanan' : 'Pilih Meja & Pesan' }}</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <p class="text-center text-[10px] font-mono text-coffee-600 uppercase tracking-widest opacity-60">
                        @if(session('table_id'))
                            Meja {{ session('table_number') }} - Pastikan pesanan Anda sudah benar
                        @else
                            Silakan pilih nomor meja Anda sebelum melanjutkan
                        @endif
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    function renderCart() {
        const container = document.getElementById('cartItems');
        container.innerHTML = '';
        
        if (Object.keys(cart).length === 0) {
            container.innerHTML = `
                <div class="text-center py-16 bg-white dark:bg-stone-800 rounded-2xl border border-stone-100 dark:border-stone-700 border-dashed">
                    <div class="w-20 h-20 bg-stone-100 dark:bg-stone-700 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <p class="text-stone-500 dark:text-stone-400 font-medium">Keranjang Anda kosong</p>
                    <a href="{{ route('customer.index') }}" class="inline-block mt-4 text-coffee-600 hover:text-coffee-700 font-bold text-sm">Mulai Pesan &rarr;</a>
                </div>`;
            document.getElementById('checkoutForm').style.display = 'none';
            const summary = document.getElementById('orderSummary');
            if (summary) summary.style.opacity = '0.5';
            updateTotals();
            return;
        }

        document.getElementById('checkoutForm').style.display = 'block';
        const summary = document.getElementById('orderSummary');
        if (summary) summary.style.opacity = '1';

        for (const [id, item] of Object.entries(cart)) {
            const itemElement = document.createElement('div');
            itemElement.className = 'bg-white dark:bg-stone-800 p-4 rounded-xl shadow-sm border border-stone-100 dark:border-stone-700 flex items-center justify-between group hover:border-coffee-200 dark:hover:border-coffee-900 transition-colors';
            itemElement.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-coffee-100 dark:bg-coffee-900/30 flex items-center justify-center text-coffee-600 font-bold text-sm">
                        ${item.quantity}x
                    </div>
                    <div>
                        <h3 class="font-bold text-stone-900 dark:text-stone-100">${item.name}</h3>
                        <p class="text-sm text-stone-500 dark:text-stone-400">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-stone-900 dark:text-stone-100">
                        Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}
                    </span>
                    <button onclick="removeFromCart(${id})" class="p-2 text-stone-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Hapus">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
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

        document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        document.getElementById('tax').textContent = `Rp ${tax.toLocaleString('id-ID')}`;
        document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        
        // Prepare data for submission
        const items = Object.values(cart).map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price
        }));
        document.getElementById('itemsInput').value = JSON.stringify(items);
    }

    renderCart();
</script>
@endpush
@endsection
