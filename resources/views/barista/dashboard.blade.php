@extends('layouts.app')

@section('title', 'Barista Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-12">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Produksi Barista</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-stone-900 font-heading uppercase tracking-tight">Antrean Pesanan</h1>
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mt-4">Kelola antrean dan ketersediaan stok</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Order Queue (2/3 width) -->
        <div class="lg:col-span-2 space-y-8">
            <div id="order-queue" class="space-y-8">
                @forelse($orders as $order)
                <div class="bg-white rounded-[40px] overflow-hidden shadow-sm border border-stone-100 transition-all duration-500 group">
                    
                    <!-- Header -->
                    <div class="p-8 border-b border-stone-50 {{ $order->status == 'confirmed' ? 'bg-stone-900 text-white' : ($order->status == 'preparing' ? 'bg-stone-50 text-stone-900' : 'bg-green-50 text-green-900') }}">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-2xl tracking-tight mb-2">PESANAN #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest {{ $order->status == 'confirmed' ? 'text-white/60' : 'text-stone-400' }}">
                                    <span class="px-3 py-1 bg-white/10 rounded-full border border-white/10 {{ $order->status == 'confirmed' ? 'text-white' : 'bg-stone-900 text-white' }}">MEJA {{ $order->table->number }}</span>
                                    <span>•</span>
                                    <span>{{ $order->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <span class="px-5 py-2 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] border {{ $order->status == 'confirmed' ? 'border-white/20 bg-white/10 text-white' : ($order->status == 'preparing' ? 'border-stone-200 bg-white text-stone-900' : 'border-green-200 bg-white text-green-600') }}">
                                {{ $order->status == 'confirmed' ? 'Antrean Baru' : ($order->status == 'preparing' ? 'Sedang Dibuat' : 'Siap Disajikan') }}
                            </span>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="p-8 space-y-6">
                        @foreach($order->items as $item)
                        <div class="flex items-start gap-6 p-6 rounded-3xl bg-stone-50/50 border border-stone-100">
                            <!-- Image -->
                            <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 border border-stone-100 shadow-sm">
                                <img src="{{ str_starts_with($item->menu->image, 'http') ? $item->menu->image : asset('storage/' . $item->menu->image) }}" 
                                     alt="{{ $item->menu->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <!-- Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-2xl font-bold text-stone-900 tracking-tight leading-none">
                                        <span class="text-stone-400 mr-2">{{ $item->quantity }}x</span>{{ $item->menu->name }}
                                    </h4>
                                </div>
                                @if($item->note)
                                <div class="mt-4 p-4 rounded-2xl bg-white border border-red-100 flex items-start gap-3">
                                    <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5 shrink-0"></div>
                                    <p class="text-xs font-semibold text-red-600 uppercase tracking-wide leading-relaxed">"{{ $item->note }}"</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Action Bar -->
                    <div class="p-8 bg-stone-50 border-t border-stone-50">
                        @if($order->status == 'confirmed')
                            <form action="{{ route('barista.update-status', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="w-full py-5 bg-stone-900 text-white rounded-2xl font-bold text-[10px] uppercase tracking-[0.4em] hover:bg-stone-800 shadow-lg shadow-stone-200 transition-all flex items-center justify-center gap-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                    Mulai Kerjakan
                                </button>
                            </form>
                        @elseif($order->status == 'preparing')
                            <form action="{{ route('barista.update-status', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="w-full py-5 bg-stone-900 text-white rounded-2xl font-bold text-[10px] uppercase tracking-[0.4em] hover:bg-stone-800 shadow-lg shadow-stone-200 transition-all flex items-center justify-center gap-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Tandai Pesanan Siap
                                </button>
                            </form>
                        @elseif($order->status == 'ready')
                            <form action="{{ route('barista.update-status', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="w-full py-5 bg-stone-900 text-white rounded-2xl font-bold text-[10px] uppercase tracking-[0.4em] hover:bg-stone-800 shadow-lg shadow-stone-200 transition-all flex items-center justify-center gap-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Selesaikan Pesanan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-32 bg-white rounded-[40px] border border-stone-100 shadow-sm border-dashed">
                    <div class="w-20 h-20 rounded-full bg-stone-50 flex items-center justify-center text-stone-200 mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 font-heading uppercase tracking-widest mb-1">Antrean Kosong</h3>
                    <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest">Istirahat sejenak, antrean sudah bersih.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Stock Management -->
        <div class="space-y-8">
            <div class="sticky top-32">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-8 h-0.5 bg-stone-900"></div>
                    <h2 class="text-xl font-bold text-stone-900 font-heading uppercase tracking-tight">Kontrol Stok</h2>
                </div>
                
                <div class="bg-white rounded-[40px] overflow-hidden shadow-sm border border-stone-100">
                    <div class="max-h-[calc(100vh-250px)] overflow-y-auto no-scrollbar">
                        <div class="divide-y divide-stone-50">
                            @foreach($menus as $menu)
                            <div class="p-8 hover:bg-stone-50 transition-all duration-500">
                                <div class="flex flex-col gap-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl overflow-hidden shrink-0 bg-stone-100 border border-stone-100">
                                            <img src="{{ str_starts_with($menu->image, 'http') ? $menu->image : asset('storage/' . $menu->image) }}" 
                                                 alt="{{ $menu->name }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-stone-900 text-sm uppercase tracking-tight truncate">{{ $menu->name }}</p>
                                            <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-widest {{ $menu->stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                                                {{ $menu->stock > 0 ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('barista.update-stock', $menu) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="number" name="stock" value="{{ $menu->stock }}" min="0" 
                                               class="flex-1 px-4 py-3 text-sm font-bold text-center border border-stone-100 rounded-2xl bg-stone-50 text-stone-900 focus:bg-white focus:ring-2 focus:ring-stone-900 focus:border-transparent transition-all">
                                        <button type="submit" class="w-12 h-12 bg-stone-900 text-white rounded-2xl hover:bg-stone-800 transition-all flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
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
                const newQueue = doc.getElementById('order-queue');
                const currentQueue = document.getElementById('order-queue');
                if (newQueue && currentQueue) currentQueue.innerHTML = newQueue.innerHTML;
                timeLeft = 10;
                if (timerEl) timerEl.textContent = timeLeft;
            })
            .catch(error => console.error('Error refreshing orders:', error));
    }

    setInterval(() => {
        timeLeft--;
        if (timerEl) timerEl.textContent = timeLeft;
        if (timeLeft <= 0) refreshOrders();
    }, 1000);
</script>
@endpush
@endsection
