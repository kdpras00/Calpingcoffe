@extends('layouts.app')

@section('title', 'Cashier Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-12">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Operasional Kasir</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-stone-900 font-heading uppercase tracking-tight">Dashboard Kasir</h1>
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mt-4">Kelola pesanan dan pembayaran real-time</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white px-6 py-4 rounded-2xl shadow-sm border border-stone-100">
            <div class="relative flex items-center justify-center">
                <div class="w-2 h-2 rounded-full bg-stone-900 animate-ping absolute"></div>
                <div class="w-2 h-2 rounded-full bg-stone-900 relative"></div>
            </div>
            <span class="text-[10px] font-bold text-stone-900 uppercase tracking-[0.2em]">
                Auto Refresh: <span id="timer" class="text-stone-400 ml-1">10</span>s
            </span>
        </div>
    </div>

    <!-- Tabs Container -->
    <div x-data="{ activeTab: 'orders' }" class="space-y-12">
        <!-- Modern Tab Switcher -->
        <div class="flex p-1.5 bg-stone-100 rounded-2xl w-fit">
            <button @click="activeTab = 'orders'; document.getElementById('orders-section').classList.remove('hidden'); document.getElementById('tables-section').classList.add('hidden')" 
                    :class="activeTab === 'orders' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-400 hover:text-stone-600'"
                    class="px-8 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                Antrean Pesanan
            </button>
            <button @click="activeTab = 'tables'; document.getElementById('orders-section').classList.add('hidden'); document.getElementById('tables-section').classList.remove('hidden')" 
                    :class="activeTab === 'tables' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-400 hover:text-stone-600'"
                    class="px-8 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                Status Meja
            </button>
        </div>

        <!-- Orders Section -->
        <div id="orders-section" class="transition-all duration-500">
            <div id="orders-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($orders as $order)
                <div class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-stone-100 hover:shadow-xl transition-all duration-500 flex flex-col group">
                    
                    <!-- Card Header -->
                    <div class="p-8 bg-stone-50 border-b border-stone-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-2xl text-stone-900 tracking-tight mb-2">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-3 py-1 bg-stone-900 text-white text-[9px] font-bold uppercase tracking-widest rounded-full">
                                        {{ $order->table ? 'MEJA ' . $order->table->number : 'Lainnya' }}
                                    </span>
                                    <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest ml-1">{{ $order->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold text-stone-900">
                                    <span class="text-[10px] text-stone-400 font-normal mr-1">IDR</span>{{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>
                                <div class="mt-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $order->payment_status == 'paid' ? 'bg-green-50 text-green-600' : 'bg-stone-200 text-stone-600' }}">
                                        <div class="w-1 h-1 rounded-full {{ $order->payment_status == 'paid' ? 'bg-green-600' : 'bg-stone-600' }}"></div>
                                        {{ $order->payment_status == 'paid' ? 'Lunas' : 'Menunggu' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="p-8 space-y-6 flex-grow max-h-[400px] overflow-y-auto no-scrollbar">
                        @foreach($order->items as $item)
                        <div class="flex items-start gap-5">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-stone-100 shrink-0 border border-stone-100">
                                <img src="{{ str_starts_with($item->menu->image, 'http') ? $item->menu->image : asset('storage/' . $item->menu->image) }}" 
                                     alt="{{ $item->menu->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <p class="font-bold text-stone-900 text-sm uppercase tracking-tight truncate">{{ $item->menu->name }}</p>
                                    <p class="text-sm font-bold text-stone-900 ml-2">x{{ $item->quantity }}</p>
                                </div>
                                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2">@ IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                                @if($item->note)
                                <div class="bg-stone-50 rounded-lg p-2 border border-stone-100">
                                    <p class="text-[9px] text-stone-500 font-medium leading-relaxed italic">"{{ $item->note }}"</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Actions Footer -->
                    <div class="p-8 bg-stone-50/50 border-t border-stone-100 mt-auto">
                        @if($order->payment_status == 'pending')
                        <div class="grid grid-cols-2 gap-4">
                            <form action="{{ route('cashier.cancel', $order) }}" method="POST" onsubmit="cancelOrder(event)" class="col-span-1">
                                @csrf
                                <button type="submit" class="w-full py-4 rounded-2xl text-stone-400 hover:text-red-500 hover:bg-red-50 font-bold text-[10px] uppercase tracking-[0.2em] transition-all border border-stone-100">
                                    Batalkan
                                </button>
                            </form>
                            <form action="{{ route('cashier.confirm-payment', $order) }}" method="POST" onsubmit="confirmPayment(event)" class="col-span-1">
                                @csrf
                                <button type="submit" class="w-full py-4 rounded-2xl bg-stone-900 text-white hover:bg-stone-800 shadow-lg shadow-stone-200 font-bold text-[10px] uppercase tracking-[0.2em] transition-all">
                                    Bayar
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="flex gap-4">
                            <div class="flex-1 py-4 bg-green-50 text-green-600 rounded-2xl font-bold text-[10px] uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Lunas
                            </div>
                            <button onclick="printReceipt({{ $order->id }})" class="flex-1 py-4 bg-white border border-stone-200 rounded-2xl text-stone-900 hover:bg-stone-50 font-bold text-[10px] uppercase tracking-[0.2em] transition-all flex items-center justify-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Struk
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full py-32 flex flex-col items-center justify-center gap-6">
                    <div class="w-24 h-24 rounded-full bg-stone-50 flex items-center justify-center text-stone-200">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-stone-900 font-heading uppercase tracking-widest mb-1">Antrean Kosong</h3>
                        <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest">Belum ada pesanan masuk saat ini</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Status Meja Section -->
        <div id="tables-section" class="hidden transition-all duration-500">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($tables as $table)
                <div class="bg-white rounded-[32px] p-8 border transition-all duration-500 flex flex-col items-center gap-6
                    {{ $table->is_occupied 
                        ? 'border-red-100 shadow-sm' 
                        : 'border-stone-100 shadow-sm hover:shadow-xl hover:-translate-y-1' }}">
                    
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] font-bold uppercase tracking-[0.3em] {{ $table->is_occupied ? 'text-red-300' : 'text-stone-300' }} mb-2">Meja</span>
                        <span class="text-6xl font-bold font-heading {{ $table->is_occupied ? 'text-red-900' : 'text-stone-900' }}">
                            {{ $table->number }}
                        </span>
                    </div>
                    
                    <div class="flex flex-col items-center gap-6 w-full">
                        <span class="px-5 py-2 rounded-full text-[9px] font-bold uppercase tracking-widest
                            {{ $table->is_occupied 
                                ? 'bg-red-50 text-red-600' 
                                : 'bg-stone-50 text-stone-400' }}">
                            {{ $table->is_occupied ? 'Terisi' : 'Kosong' }}
                        </span>

                        @if($table->is_occupied)
                        <form action="{{ route('cashier.tables.vacate', $table) }}" method="POST" onsubmit="vacateTable(event, '{{ $table->number }}')" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-stone-900 text-white rounded-2xl py-3.5 text-[9px] font-bold uppercase tracking-widest hover:bg-stone-800 transition-all shadow-lg shadow-stone-200">
                                Kosongkan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let timeLeft = 10;
    const timerEl = document.getElementById('timer');
    
    function refreshOrders() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newOrdersGrid = doc.getElementById('orders-grid');
                const currentOrdersGrid = document.getElementById('orders-grid');
                if (newOrdersGrid && currentOrdersGrid) {
                    currentOrdersGrid.innerHTML = newOrdersGrid.innerHTML;
                }
                
                const newTablesSection = doc.getElementById('tables-section');
                const currentTablesSection = document.getElementById('tables-section');
                if (newTablesSection && currentTablesSection) {
                    currentTablesSection.innerHTML = newTablesSection.innerHTML;
                }
                
                timeLeft = 10;
                if (timerEl) timerEl.textContent = timeLeft;
            })
            .catch(error => console.error('Error refreshing dashboard:', error));
    }

    setInterval(() => {
        timeLeft--;
        if (timerEl) timerEl.textContent = timeLeft;
        if (timeLeft <= 0) refreshOrders();
    }, 1000);

    function printReceipt(orderId) {
        window.open(`/cashier/orders/${orderId}/print`, 'Receipt', 'width=400,height=600,resizable,scrollbars=yes,status=1');
    }

    function confirmPayment(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Pembayaran?',
            text: "Pastikan nominal pembayaran telah diterima dengan benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0c0a09',
            cancelButtonColor: '#78716c',
            confirmButtonText: 'Ya, Selesaikan',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            color: '#0c0a09',
            customClass: {
                confirmButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest',
                cancelButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) event.target.submit();
        });
    }

    function vacateTable(event, tableNumber) {
        event.preventDefault();
        Swal.fire({
            title: `Kosongkan Meja ${tableNumber}?`,
            text: "QR Token meja ini akan diperbarui secara otomatis.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0c0a09',
            cancelButtonColor: '#78716c',
            confirmButtonText: 'Ya, Kosongkan',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            color: '#0c0a09',
            customClass: {
                confirmButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest',
                cancelButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) event.target.submit();
        });
    }

    function cancelOrder(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Batalkan Pesanan?',
            text: "Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#78716c',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Kembali',
            background: '#ffffff',
            color: '#0c0a09',
            customClass: {
                confirmButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest',
                cancelButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) event.target.submit();
        });
    }
</script>
@endpush
@endsection
