@extends('layouts.customer')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white px-4 py-16">
    <div class="max-w-2xl w-full space-y-12">
        
        <!-- Header -->
        <div class="text-center">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Status Pesanan</span>
                <div class="w-8 h-0.5 bg-stone-900"></div>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold font-heading text-stone-900 uppercase tracking-tight mb-6">
                ORDER <span class="text-stone-300">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
            </h1>
            <div class="inline-flex items-center gap-4 bg-stone-900 text-white px-8 py-3 rounded-full shadow-lg shadow-stone-200">
                <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Meja</span>
                <span class="text-xl font-bold font-heading">{{ $order->table->number }}</span>
            </div>
        </div>

        <!-- Progress Tracking -->
        <div class="bg-stone-50 rounded-[40px] p-10 md:p-16 border border-stone-100">
            <div class="relative flex justify-between items-start">
                <!-- Track Line -->
                <div class="absolute top-6 left-6 right-6 h-[2px] bg-stone-200"></div>
                <div class="absolute top-6 left-6 h-[2px] bg-stone-900 transition-all duration-1000" style="width: {{ $progress }}%;"></div>

                @php
                    $steps = [
                        ['label' => 'Order', 'status' => 'confirmed'],
                        ['label' => 'Payment', 'status' => 'paid'],
                        ['label' => 'Process', 'status' => 'preparing'],
                        ['label' => 'Ready', 'status' => 'ready']
                    ];
                    
                    $currentStatusIndex = 0;
                    if ($order->payment_status == 'paid') $currentStatusIndex = 1;
                    if ($order->status == 'preparing') $currentStatusIndex = 2;
                    if (in_array($order->status, ['ready', 'completed'])) $currentStatusIndex = 3;
                @endphp

                @foreach($steps as $index => $step)
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full border-2 transition-all duration-500 flex items-center justify-center
                            {{ $index <= $currentStatusIndex 
                                ? 'bg-stone-900 border-stone-900 text-white shadow-xl shadow-stone-200' 
                                : 'bg-white border-stone-200 text-stone-200' }}">
                            @if($index < $currentStatusIndex)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <span class="text-xs font-bold">{{ $index + 1 }}</span>
                            @endif
                        </div>
                        <span class="mt-4 text-[9px] font-bold uppercase tracking-[0.2em] {{ $index <= $currentStatusIndex ? 'text-stone-900' : 'text-stone-300' }}">
                            {{ $step['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Status Messaging -->
            <div class="mt-16 text-center">
                @if($order->status == 'pending')
                    <h2 class="text-3xl font-bold text-stone-900 uppercase tracking-tight mb-4">Selesaikan Pembayaran</h2>
                    <p class="text-stone-400 text-xs font-medium uppercase tracking-widest mb-8">Mohon selesaikan pembayaran untuk memproses pesanan</p>
                    <a href="{{ route('customer.payment', $order) }}" class="inline-flex items-center gap-4 bg-stone-900 text-white px-10 py-5 rounded-full font-bold text-[10px] uppercase tracking-[0.3em] shadow-2xl shadow-stone-200 hover:bg-stone-800 transition-all">
                        Bayar Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @elseif($order->status == 'confirmed')
                    <h2 class="text-3xl font-bold text-stone-900 uppercase tracking-tight mb-2">Pesanan Masuk</h2>
                    <p class="text-stone-400 text-xs font-medium uppercase tracking-widest">Barista kami akan segera menyiapkan pesanan Anda</p>
                @elseif($order->status == 'preparing')
                    <div class="flex items-center justify-center gap-4 mb-2">
                        <div class="w-2 h-2 rounded-full bg-stone-900 animate-ping"></div>
                        <h2 class="text-3xl font-bold text-stone-900 uppercase tracking-tight">Sedang Dibuat</h2>
                    </div>
                    <p class="text-stone-400 text-xs font-medium uppercase tracking-widest">Kami sedang meracik rasa terbaik untuk Anda</p>
                @elseif($order->status == 'ready')
                    <div class="bg-green-50 rounded-3xl p-8 border border-green-100">
                        <h2 class="text-4xl font-bold text-green-900 uppercase tracking-tight mb-2">SIAP DIAMBIL!</h2>
                        <p class="text-green-600 text-xs font-bold uppercase tracking-widest">Silakan tunjukkan layar ini ke kasir/counter</p>
                    </div>
                @elseif($order->status == 'completed')
                    <h2 class="text-3xl font-bold text-stone-900 uppercase tracking-tight mb-2">Terima Kasih!</h2>
                    <p class="text-stone-400 text-xs font-medium uppercase tracking-widest">Selamat menikmati pesanan Anda</p>
                @elseif($order->status == 'cancelled')
                    <h2 class="text-3xl font-bold text-red-600 uppercase tracking-tight">Pesanan Dibatalkan</h2>
                @endif
            </div>
        </div>

        <!-- Receipt Details -->
        <div class="bg-white rounded-[40px] overflow-hidden border border-stone-100 shadow-sm">
            <div class="p-10 md:p-12">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-8 h-0.5 bg-stone-900"></div>
                    <h3 class="text-xs font-bold text-stone-900 uppercase tracking-[0.3em]">Detail Belanja</h3>
                </div>
                
                <div class="space-y-8">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-start group">
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-stone-400 font-bold text-xs shrink-0">
                                {{ $item->quantity }}x
                            </div>
                            <div>
                                <h4 class="font-bold text-stone-900 uppercase tracking-tight mb-1">{{ $item->menu->name }}</h4>
                                @if($item->note)
                                    <p class="text-[10px] text-stone-400 font-medium italic">"{{ $item->note }}"</p>
                                @endif
                            </div>
                        </div>
                        <span class="font-bold text-stone-900 tracking-tight">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-10 border-t border-stone-50 flex justify-between items-end">
                    <div>
                        <span class="text-[9px] font-bold text-stone-300 uppercase tracking-[0.3em]">Total Transaksi</span>
                        <div class="text-4xl font-bold font-heading text-stone-900 tracking-tighter mt-1">
                            <span class="text-xs font-normal text-stone-400 mr-1">IDR</span>{{ number_format($order->total_amount, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y') }}</span>
                        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">{{ $order->created_at->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="pt-8">
            @if(in_array($order->status, ['ready', 'completed', 'cancelled']))
                <a href="{{ route('customer.index') }}" class="w-full bg-stone-900 text-white font-bold py-6 rounded-full shadow-2xl shadow-stone-200 hover:bg-stone-800 transition-all flex items-center justify-center gap-6 group">
                    <span class="uppercase tracking-[0.3em] text-xs">Pesan Lagi</span>
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:translate-x-2 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>
            @else
                <div class="text-center">
                    <a href="{{ route('customer.index') }}" class="inline-flex items-center gap-4 text-stone-400 hover:text-stone-900 font-bold uppercase tracking-[0.2em] text-[10px] transition-all group">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Menu
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    setInterval(() => {
        fetch('{{ route('payment.check', $order->id) }}')
            .then(response => response.json())
            .then(data => {
                if (data.order_status !== '{{ $order->status }}') {
                    window.location.reload();
                }
            })
            .catch(console.error);
    }, 5000);

    setTimeout(() => {
        if (window.Echo) {
            window.Echo.channel('orders')
                .listen('OrderStatusUpdated', (e) => {
                    if (e.order.id == {{ $order->id }}) {
                        window.location.reload();
                    }
                });
        }
    }, 1000);

    @if($order->status == 'ready')
        document.addEventListener('DOMContentLoaded', function() {
            const orderId = "{{ $order->id }}";
            const storageKey = `notified_ready_${orderId}`;
            
            if (!sessionStorage.getItem(storageKey)) {
                const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
                audio.play().catch(error => console.log('Audio autoplay blocked:', error));

                if (navigator.vibrate) {
                    navigator.vibrate([200, 100, 200, 100, 500]);
                }

                Swal.fire({
                    title: 'PESANAN SIAP!',
                    text: 'Silakan ambil pesanan Anda di kasir sekarang.',
                    icon: 'success',
                    confirmButtonText: 'SIAP DIAMBIL',
                    confirmButtonColor: '#0c0a09',
                    background: '#ffffff',
                    color: '#0c0a09',
                    customClass: {
                        confirmButton: 'rounded-full px-10 py-4 uppercase text-[10px] font-bold tracking-[0.3em]'
                    }
                });

                sessionStorage.setItem(storageKey, 'true');
            }
        });
    @endif
</script>
@endpush
@endsection
```
