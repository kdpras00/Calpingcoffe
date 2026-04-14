@extends('layouts.app')

@section('title', 'Dashboard Barista')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-stone-800 dark:text-stone-100">Dashboard Barista</h1>
            <p class="text-stone-500 dark:text-stone-400 mt-1">Antrean Pesanan & Manajemen Stok</p>
        </div>
        <div class="flex items-center gap-2 bg-white dark:bg-stone-900 px-4 py-2 rounded-lg shadow-sm border border-stone-200 dark:border-stone-800">
            <svg class="w-5 h-5 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm text-stone-600 dark:text-stone-300">
                Auto-refresh: <span id="timer" class="font-bold text-amber-600">10</span>s
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Queue (2/3 width) -->
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-xl font-bold text-stone-800 dark:text-stone-100 flex items-center gap-2">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Antrean Pesanan
            </h2>
            
            <div id="order-queue" class="space-y-4">
                @forelse($orders as $order)
                <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-800 overflow-hidden">
                    
                    <!-- Header -->
                    <div class="p-4 bg-gradient-to-r {{ $order->status == 'confirmed' ? 'from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20' : ($order->status == 'preparing' ? 'from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20' : 'from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20') }} border-b border-stone-200 dark:border-stone-700">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-xl text-stone-800 dark:text-stone-100">Pesanan #{{ $order->id }}</h3>
                                <div class="flex items-center gap-2 text-sm text-stone-600 dark:text-stone-300 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="font-medium">Meja {{ $order->table->number }}</span>
                                    <span>•</span>
                                    <span>{{ $order->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                                {{ $order->status == 'confirmed' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 
                                   ($order->status == 'preparing' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 
                                   'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400') }}">
                                {{ $order->status == 'confirmed' ? 'Baru' : ($order->status == 'preparing' ? 'Diproses' : 'Siap') }}
                            </span>
                        </div>
                    </div>

                    <!-- Menu Items with Images -->
                    <div class="p-4 space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-3 p-3 bg-stone-50 dark:bg-stone-800/50 rounded-lg">
                            <!-- Menu Image -->
                            <div class="flex-shrink-0">
                                <img src="{{ str_starts_with($item->menu->image, 'http') ? $item->menu->image : asset('storage/' . $item->menu->image) }}" 
                                     alt="{{ $item->menu->name }}" 
                                     class="w-16 h-16 rounded-lg object-cover border-2 border-white dark:border-stone-700 shadow-sm">
                            </div>
                            
                            <!-- Menu Details -->
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="font-bold text-lg text-stone-800 dark:text-stone-100">
                                        <span class="text-amber-600 dark:text-amber-500">{{ $item->quantity }}x</span> {{ $item->menu->name }}
                                    </p>
                                </div>
                                @if($item->note)
                                <div class="mt-2 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg border border-red-200 dark:border-red-800 flex items-start gap-2">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <span><strong>Catatan:</strong> {{ $item->note }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Actions -->
                    <div class="p-4 bg-stone-50 dark:bg-stone-800/50 border-t border-stone-200 dark:border-stone-700">
                        @if($order->status == 'confirmed')
                            <form action="{{ route('barista.update-status', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Mulai Siapkan
                                </button>
                            </form>
                        @elseif($order->status == 'preparing')
                            <form action="{{ route('barista.update-status', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Tandai Siap
                                </button>
                            </form>
                        @elseif($order->status == 'ready')
                            <form action="{{ route('barista.update-status', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="w-full bg-gradient-to-r from-stone-700 to-stone-900 hover:from-stone-800 hover:to-black text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Selesaikan Pesanan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-16 text-stone-400 bg-white dark:bg-stone-900 rounded-xl border-2 border-stone-200 dark:border-stone-800 border-dashed">
                    <svg class="w-20 h-20 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xl font-medium text-stone-500 dark:text-stone-400">Tidak ada pesanan aktif</p>
                    <p class="text-sm text-stone-400 dark:text-stone-500 mt-1">Waktunya bersih-bersih! 🧹</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Stock Management (1/3 width) -->
        <div>
            <div class="sticky top-24">
                <h2 class="text-xl font-bold text-stone-800 dark:text-stone-100 flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Stok
                </h2>
                
                <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-stone-200 dark:border-stone-800 overflow-hidden">
                    <div class="max-h-[calc(100vh-200px)] overflow-y-auto">
                        <div class="divide-y divide-stone-200 dark:divide-stone-700">
                            @foreach($menus as $menu)
                            <div class="p-4 hover:bg-stone-50 dark:hover:bg-stone-800/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <!-- Menu Image -->
                                    <img src="{{ str_starts_with($menu->image, 'http') ? $menu->image : asset('storage/' . $menu->image) }}" 
                                         alt="{{ $menu->name }}" 
                                         class="w-12 h-12 rounded-lg object-cover border border-stone-200 dark:border-stone-700 flex-shrink-0">
                                    
                                    <!-- Menu Info & Stock Control -->
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-stone-800 dark:text-stone-100 truncate">{{ $menu->name }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $menu->stock > 0 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $menu->stock > 0 ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Stock Input -->
                                    <form action="{{ route('barista.update-stock', $menu) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="stock" value="{{ $menu->stock }}" min="0" 
                                               class="w-16 px-2 py-1.5 text-sm text-center border border-stone-300 dark:border-stone-600 rounded-lg bg-white dark:bg-stone-800 text-stone-700 dark:text-stone-300 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                        <button type="submit" class="p-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors" title="Update">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
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
    // Auto refresh using AJAX
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
                
                if (newQueue && currentQueue) {
                    currentQueue.innerHTML = newQueue.innerHTML;
                }
                
                // Reset timer
                timeLeft = 10;
                if (timerEl) timerEl.textContent = timeLeft;
            })
            .catch(error => console.error('Error refreshing orders:', error));
    }

    setInterval(() => {
        timeLeft--;
        if (timerEl) timerEl.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            refreshOrders();
        }
    }, 1000);

    // Real-time listener
    setTimeout(() => {
        if (window.Echo) {
            window.Echo.channel('orders')
                .listen('OrderStatusUpdated', (e) => {
                    console.log('Status Updated:', e.order);
                    refreshOrders();
                })
                .listen('OrderCreated', (e) => {
                    console.log('New Order:', e.order);
                    refreshOrders();
                });
        }
    }, 1000);
</script>
@endpush
@endsection
