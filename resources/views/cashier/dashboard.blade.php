@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-coffee-900 uppercase tracking-tighter">Dashboard Kasir</h1>
            <p class="text-xs font-mono font-bold text-coffee-600 uppercase tracking-widest mt-1">Kelola pesanan dan pembayaran</p>
        </div>
        <div class="flex items-center gap-3 bg-white border-2 border-coffee-900 px-6 py-3 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]">
            <svg class="w-5 h-5 text-tuku-mustard animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
            </svg>
            <span class="text-xs font-mono font-bold text-coffee-900 uppercase tracking-widest">
                Refresh: <span id="timer" class="text-tuku-mustard">10</span>s
            </span>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-10 flex gap-4 p-1 bg-coffee-300/30 border-2 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] rounded-none max-w-lg" x-data="{ activeTab: 'orders' }">
        <button @click="activeTab = 'orders'; document.getElementById('orders-section').classList.remove('hidden'); document.getElementById('tables-section').classList.add('hidden')" 
                :class="activeTab === 'orders' ? 'bg-coffee-900 text-white' : 'text-coffee-600 hover:text-coffee-900'"
                class="flex-1 py-3 px-6 font-black text-xs uppercase tracking-widest transition-all flex items-center justify-center gap-2">
            Pesanan
        </button>
        <button @click="activeTab = 'tables'; document.getElementById('orders-section').classList.add('hidden'); document.getElementById('tables-section').classList.remove('hidden')" 
                :class="activeTab === 'tables' ? 'bg-coffee-900 text-white' : 'text-coffee-600 hover:text-coffee-900'"
                class="flex-1 py-3 px-6 font-black text-xs uppercase tracking-widest transition-all flex items-center justify-center gap-2">
            Status Meja
        </button>
    </div>

    <!-- Orders Section -->
    <div id="orders-section">
        <div id="orders-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($orders as $order)
            <div class="bg-white border-2 border-coffee-900 shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] hover:shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
                
                <!-- Header with Table & Status -->
                <div class="p-5 bg-tuku-mustard/10 border-b-2 border-coffee-900">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-black text-xl text-coffee-900 uppercase tracking-tighter">#{{ $order->id }}</h3>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="text-[10px] font-mono font-bold bg-coffee-900 text-white px-2 py-0.5 uppercase tracking-widest">Meja {{ $order->table->number }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-black text-coffee-900 font-heading">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </div>
                            <span class="inline-block px-2 py-0.5 border border-coffee-900 text-[10px] font-mono font-bold uppercase tracking-widest mt-1
                                {{ $order->payment_status == 'paid' ? 'bg-green-500 text-white' : 'bg-white text-coffee-900' }}">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : 'Menunggu' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="p-5 space-y-4 max-h-80 overflow-y-auto no-scrollbar">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 group">
                        <!-- Menu Image -->
                        <div class="flex-shrink-0 border-2 border-coffee-900 shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                            <img src="{{ str_starts_with($item->menu->image, 'http') ? $item->menu->image : asset('storage/' . $item->menu->image) }}" 
                                 alt="{{ $item->menu->name }}" 
                                 class="w-14 h-14 object-cover">
                        </div>
                        
                        <!-- Menu Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1">
                                    <p class="font-bold text-sm text-coffee-900 uppercase tracking-tight truncate">{{ $item->menu->name }}</p>
                                    <p class="text-[10px] font-mono text-coffee-500 font-bold uppercase tracking-widest">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-black text-xs text-coffee-900 font-heading whitespace-nowrap">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                            @if($item->note)
                            <div class="mt-1 text-[9px] font-mono text-tuku-mustard italic flex items-start gap-1">
                                <span>"{{ $item->note }}"</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Actions -->
                <div class="p-5 bg-coffee-100/50 border-t-2 border-coffee-900">
                    @if($order->payment_status == 'pending')
                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-2 bg-white border-2 border-dashed border-coffee-300 p-3">
                            <div class="flex items-center gap-2 text-coffee-400">
                                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-bold text-[9px] font-mono uppercase tracking-widest">Waiting Payment...</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <form action="{{ route('cashier.cancel', $order) }}" method="POST" onsubmit="cancelOrder(event)">
                                @csrf
                                <button type="submit" class="w-full bg-white hover:bg-red-50 text-red-600 border-2 border-red-200 font-black text-[10px] py-3 uppercase tracking-widest transition-all">
                                    Batal
                                </button>
                            </form>

                            <form action="{{ route('cashier.confirm-payment', $order) }}" method="POST" onsubmit="confirmPayment(event)">
                                @csrf
                                <button type="submit" class="w-full bg-coffee-900 text-white hover:bg-black font-black text-[10px] py-3 uppercase tracking-widest shadow-[4px_4px_0px_0px_rgba(229,161,36,0.3)] transition-all">
                                    Bayar
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="flex gap-3">
                        <div class="flex-1 bg-green-500 text-white font-black text-[10px] py-4 text-center uppercase tracking-widest flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Lunas
                        </div>
                        <button class="flex-1 bg-white border-2 border-coffee-900 text-coffee-900 font-black text-[10px] py-4 uppercase tracking-widest hover:bg-coffee-50 transition-colors flex items-center justify-center gap-2" onclick="printReceipt({{ $order->id }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full border-4 border-dashed border-coffee-300 py-20 flex flex-col items-center justify-center text-coffee-300">
                <svg class="w-20 h-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <p class="text-xl font-black uppercase tracking-widest">Antrean Kosong</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Tables Section (Table Map) -->
    <div id="tables-section" class="hidden">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($tables as $table)
            <div class="p-6 border-2 transition-all flex flex-col items-center justify-center gap-4
                {{ $table->is_occupied 
                    ? 'bg-red-50 border-red-500 shadow-[6px_6px_0px_0px_rgba(239,68,68,1)]' 
                    : 'bg-white border-coffee-900 shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] hover:shadow-[10px_10px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1' }}">
                
                <span class="text-xs font-mono font-black uppercase tracking-widest {{ $table->is_occupied ? 'text-red-500' : 'text-coffee-600' }}">Meja</span>
                <span class="text-5xl font-black font-heading {{ $table->is_occupied ? 'text-red-700' : 'text-coffee-900' }}">
                    {{ $table->number }}
                </span>
                
                <span class="px-3 py-1 text-[9px] font-mono font-black uppercase tracking-widest transition-colors
                    {{ $table->is_occupied 
                        ? 'bg-red-500 text-white' 
                        : 'bg-green-500 text-white' }}">
                    {{ $table->is_occupied ? 'Terisi' : 'Kosong' }}
                </span>

                @if($table->is_occupied)
                <form action="{{ route('cashier.tables.vacate', $table) }}" method="POST" onsubmit="vacateTable(event, '{{ $table->number }}')">
                    @csrf
                    <button type="submit" class="mt-2 w-full bg-coffee-900 text-white text-[9px] font-black py-2.5 px-4 uppercase tracking-widest hover:bg-black transition-all border-2 border-coffee-900">
                        Kosongkan
                    </button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto refresh using AJAX
    let timeLeft = 10;
    const timerEl = document.getElementById('timer');
    
    function refreshOrders() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Refresh Orders
                const newOrdersGrid = doc.getElementById('orders-grid');
                const currentOrdersGrid = document.getElementById('orders-grid');
                if (newOrdersGrid && currentOrdersGrid) {
                    currentOrdersGrid.innerHTML = newOrdersGrid.innerHTML;
                }
                
                // Refresh Tables
                const newTablesSection = doc.getElementById('tables-section');
                const currentTablesSection = document.getElementById('tables-section');
                if (newTablesSection && currentTablesSection) {
                    currentTablesSection.innerHTML = newTablesSection.innerHTML;
                }
                
                // Reset timer
                timeLeft = 10;
                if (timerEl) timerEl.textContent = timeLeft;
            })
            .catch(error => console.error('Error refreshing dashboard:', error));
    }

    setInterval(() => {
        timeLeft--;
        if (timerEl) timerEl.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            refreshOrders();
        }
    }, 1000);

    function printReceipt(orderId) {
        const url = `/cashier/orders/${orderId}/print`;
        const windowName = 'Receipt';
        const windowFeatures = 'width=400,height=600,resizable,scrollbars=yes,status=1';
        window.open(url, windowName, windowFeatures);
    }

    // Real-time listener
    setTimeout(() => {
        if (window.Echo) {
            window.Echo.channel('orders')
                .listen('OrderCreated', (e) => {
                    console.log('Order Created:', e.order);
                    refreshOrders();
                });
        }
    }, 1000);

    function confirmPayment(event) {
        event.preventDefault();
        const form = event.target;
        
        Swal.fire({
            title: 'Konfirmasi Pembayaran?',
            text: "Pastikan uang tunai sudah diterima sesuai nominal.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669', // Green color
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Bayar Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function vacateTable(event, tableNumber) {
        event.preventDefault();
        const form = event.target;
        
        Swal.fire({
            title: `Kosongkan Meja ${tableNumber}?`,
            text: "Pastikan pelanggan sudah meninggalkan meja dan meja sudah dibersihkan. Token QR akan diperbarui secara otomatis.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1f2937', // Stone-800
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Kosongkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function cancelOrder(event) {
        event.preventDefault();
        const form = event.target;
        
        Swal.fire({
            title: 'Batalkan Pesanan?',
            text: "Stok akan dikembalikan dan pesanan dihapus dari antrian.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
@endpush
@endsection
