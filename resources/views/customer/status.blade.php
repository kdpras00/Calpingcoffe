@extends('layouts.customer')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-coffee-200 px-4 py-8 md:py-12">
    <div class="max-w-2xl w-full space-y-8 md:space-y-12 bg-white p-5 md:p-10 border-2 border-coffee-900 shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] md:shadow-[16px_16px_0px_0px_rgba(43,30,22,1)] relative overflow-hidden">
        
        <!-- Header (Poster Style) -->
        <div class="relative text-center border-b-2 border-coffee-900 pb-8">
            <h1 class="text-2xl md:text-4xl font-heading font-bold text-coffee-900 uppercase tracking-tighter mb-2">Pesanan <span class="text-coffee-600">#{{ $order->id }}</span></h1>
            <div class="inline-block bg-coffee-900 text-white px-6 py-1 rounded-full text-xs font-bold uppercase tracking-widest -rotate-2">
                Meja {{ $order->table->number }}
            </div>
        </div>

        <!-- Status Progress (Bold & Tactile) -->
        <div class="relative py-12">
            <div class="flex justify-between items-start relative px-4">
                <!-- Line Background -->
                <div class="absolute top-5 left-8 right-8 h-1 bg-coffee-100 z-0"></div>
                <!-- Line Active -->
                <div class="absolute top-5 left-8 h-1 bg-coffee-900 z-0 transition-all duration-500" style="width: calc({{ $progress }}% - 16px);"></div>

                <!-- Step 1 -->
                <div class="flex flex-col items-center relative z-10 flex-1">
                    <div class="w-10 h-10 border-2 border-coffee-900 bg-coffee-900 text-white flex items-center justify-center shadow-[2px_2px_0px_0px_rgba(43,30,22,1)] mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-coffee-900 uppercase tracking-widest">Antre</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center relative z-10 flex-1">
                    <div class="w-10 h-10 border-2 border-coffee-900 {{ $order->status != 'pending' ? 'bg-coffee-900 text-white' : 'bg-white text-coffee-300' }} flex items-center justify-center shadow-[2px_2px_0px_0px_rgba(43,30,22,1)] mb-4">
                        @if($order->status != 'pending')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <span class="font-bold">2</span>
                        @endif
                    </div>
                    <span class="text-[10px] font-bold {{ $order->status != 'pending' ? 'text-coffee-900' : 'text-coffee-300' }} uppercase tracking-widest">Ok</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center relative z-10 flex-1">
                    <div class="w-10 h-10 border-2 border-coffee-900 {{ in_array($order->status, ['preparing', 'ready', 'completed']) ? 'bg-coffee-900 text-white' : 'bg-white text-coffee-300' }} flex items-center justify-center shadow-[2px_2px_0px_0px_rgba(43,30,22,1)] mb-4">
                         @if(in_array($order->status, ['preparing', 'ready', 'completed']))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <span class="font-bold">3</span>
                        @endif
                    </div>
                    <span class="text-[10px] font-bold {{ in_array($order->status, ['preparing', 'ready', 'completed']) ? 'text-coffee-900' : 'text-coffee-300' }} uppercase tracking-widest">Proses</span>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center relative z-10 flex-1">
                    <div class="w-10 h-10 border-2 border-coffee-900 {{ in_array($order->status, ['ready', 'completed']) ? 'bg-coffee-900 text-white shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]' : 'bg-white text-coffee-300' }} flex items-center justify-center mb-4">
                         @if(in_array($order->status, ['ready', 'completed']))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <span class="font-bold">4</span>
                        @endif
                    </div>
                    <span class="text-[10px] font-bold {{ in_array($order->status, ['ready', 'completed']) ? 'text-coffee-900' : 'text-coffee-300' }} uppercase tracking-widest">Siap!</span>
                </div>
            </div>
        </div>

        <!-- Current Status Message -->
        <div class="relative bg-coffee-200 border-2 border-coffee-900 p-5 md:p-8 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] md:shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] text-center md:-rotate-1">
            @if($order->status == 'pending')
                <h2 class="text-2xl font-heading font-bold text-coffee-900 mb-4 uppercase tracking-tighter">Bayar Terlebih Dahulu</h2>
                <a href="{{ route('customer.payment', $order) }}" class="inline-block bg-coffee-900 text-white font-bold px-8 py-3 border-2 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all uppercase tracking-widest text-sm">
                    Bayar Sekarang
                </a>
            @elseif($order->status == 'confirmed')
                <h2 class="text-2xl font-heading font-bold text-coffee-900 uppercase tracking-tighter">Pesanan Dikonfirmasi</h2>
                <p class="text-coffee-700 font-mono text-sm mt-2">Mohon tunggu sebentar, barista kami segera meracik.</p>
            @elseif($order->status == 'preparing')
                <h2 class="text-2xl font-heading font-bold text-coffee-900 uppercase tracking-tighter animate-pulse">Sedang Diracik...</h2>
                <p class="text-coffee-700 font-mono text-sm mt-2">Aroma kopinya sudah menyebar!</p>
            @elseif($order->status == 'ready')
                <h2 class="text-3xl font-heading font-bold text-coffee-900 uppercase tracking-tighter shadow-sm">SIAP DIAMBIL!</h2>
                <p class="text-coffee-700 font-mono font-bold mt-2">Silakan ke kasir untuk mengambil pesanan Anda.</p>
            @elseif($order->status == 'completed')
                <h2 class="text-2xl font-heading font-bold text-coffee-900 uppercase tracking-tighter">Nikmati Kopinya!</h2>
                <p class="text-coffee-700 font-mono text-sm mt-2">Terima kasih telah singgah ke CalpingCoffee.</p>
            @elseif($order->status == 'cancelled')
                <h2 class="text-2xl font-heading font-bold text-red-600 uppercase tracking-tighter">Pesanan Dibatalkan</h2>
            @endif
        </div>

        <!-- Order Items (Sticker Style List) -->
        <div class="relative bg-white border-2 border-coffee-900 md:rotate-1 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] md:shadow-[8px_8px_0px_0px_rgba(43,30,22,1)]">
            <div class="p-5 md:p-8">
                <h3 class="text-lg font-heading font-bold text-coffee-900 mb-6 flex items-center gap-3 uppercase tracking-widest">
                    <svg class="w-6 h-6 text-coffee-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Detail Belanja
                </h3>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-start py-4 border-b-2 border-dotted border-coffee-900/20 last:border-0 font-mono">
                        <div class="flex-1">
                            <div class="flex items-start gap-3">
                                <span class="inline-flex items-center justify-center w-8 h-8 border-2 border-coffee-900 bg-white text-coffee-900 font-bold text-xs">{{ $item->quantity }}</span>
                                <div>
                                    <span class="font-bold text-coffee-900 text-sm uppercase">{{ $item->menu->name }}</span>
                                    @if($item->note)
                                        <p class="text-[10px] text-coffee-600 mt-1 italic tracking-tight">Catatan: {{ $item->note }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="font-bold text-coffee-900 ml-4">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t-2 border-coffee-900">
                    <div class="flex justify-between items-center">
                        <span class="text-base font-bold text-coffee-900 uppercase tracking-widest">Total</span>
                        <span class="text-3xl font-heading font-bold text-coffee-900 tracking-tighter">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Back to Menu (Sticker Button) -->
        <div class="pt-10 flex flex-col gap-6">
            @if(in_array($order->status, ['ready', 'completed', 'cancelled']))
                <a href="{{ route('customer.index') }}" class="w-full bg-coffee-900 text-white font-bold py-5 border-2 border-coffee-900 shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] hover:shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all flex items-center justify-center gap-3 uppercase tracking-widest text-sm">
                    <span>Pesan Lagi</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            @else
                <div class="text-center">
                    <a href="{{ route('customer.index') }}" class="inline-flex items-center gap-3 text-coffee-900 opacity-60 hover:opacity-100 font-bold uppercase tracking-widest text-xs transition-opacity decoration-2 underline-offset-4 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Ke Menu
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Simple polling for status update (fallback)
    // Simple polling for status update with API check
    // Poll for any status change
    setInterval(() => {
        fetch('{{ route('payment.check', $order->id) }}')
            .then(response => response.json())
            .then(data => {
                // Reload if order status OR payment status changes relative to page load
                if (data.order_status !== '{{ $order->status }}') {
                    window.location.reload();
                }
            })
            .catch(console.error);
    }, 5000);

    // Real-time listener
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

    // Confirm payment function
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

    // Order Ready Notification (Sound + Vibrate + Alert)
    @if($order->status == 'ready')
        document.addEventListener('DOMContentLoaded', function() {
            const orderId = "{{ $order->id }}";
            const storageKey = `notified_ready_${orderId}`;
            
            if (!sessionStorage.getItem(storageKey)) {
                // 1. Play Sound
                const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3'); // Generic pleasant "ding"
                audio.play().catch(error => console.log('Audio autoplay blocked:', error));

                // 2. Vibrate (if supported)
                if (navigator.vibrate) {
                    navigator.vibrate([200, 100, 200, 100, 500]);
                }

                // 3. Visual Alert
                Swal.fire({
                    title: 'Pesanan Siap!',
                    text: 'Pesanan Anda sudah siap. Silakan ambil di kasir/counter.',
                    icon: 'success',
                    confirmButtonText: 'Oke, segera diambil',
                    confirmButtonColor: '#d97706', // Amber-600
                    backdrop: `
                        rgba(0,0,123,0.4)
                        url("/images/confetti.gif")
                        left top
                        no-repeat
                    `
                });

                // Mark as notified so it doesn't play again on refresh
                sessionStorage.setItem(storageKey, 'true');
            }
        });
    @endif
</script>
@endpush
@endsection
```
