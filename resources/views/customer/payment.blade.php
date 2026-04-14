@extends('layouts.customer')
@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-coffee-200 px-4 py-12 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 border-2 border-coffee-900 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] relative overflow-hidden">
        
        <!-- Background Pattern -->
        <div class="absolute top-0 left-0 w-full h-2 bg-coffee-900"></div>
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-coffee-900/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-coffee-900/5 rounded-full blur-3xl"></div>

        <div class="relative text-center">
            <div class="mx-auto w-20 h-20 bg-coffee-100 rounded-full border-2 border-coffee-900 flex items-center justify-center mb-6 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] animate-fade-in-up">
                <svg class="w-10 h-10 text-coffee-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h1 class="text-3xl font-heading font-bold text-coffee-900 uppercase tracking-tighter mb-2">Pesanan Dibuat!</h1>
            <p class="text-coffee-600 font-mono text-sm">Pesanan <span class="font-bold text-coffee-900">#{{ $order->id }}</span> berhasil dibuat.</p>
        </div>
        
        <div class="relative bg-coffee-100 border-2 border-coffee-900 p-6 shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] rotate-1">
            <div class="flex justify-between items-end mb-2">
                <span class="text-xs font-bold text-coffee-600 uppercase tracking-widest">Total Pembayaran</span>
                <span class="text-3xl font-bold font-heading text-coffee-900 tracking-tighter">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="h-0.5 w-full bg-coffee-900/10 my-4 border-t-2 border-dotted border-coffee-900/30"></div>
            <div class="text-[10px] text-coffee-600 font-bold uppercase tracking-widest text-center">
                Silakan selesaikan pembayaran untuk memproses pesanan Anda.
            </div>
        </div>

        <div class="space-y-4 pt-4">
            <!-- Online Payment Option -->
            <button id="pay-online-btn" class="w-full group relative flex items-center justify-between p-5 border-2 border-coffee-900 bg-white hover:bg-coffee-50 transition-all shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] active:translate-y-0.5 active:shadow-[2px_2px_0px_0px_rgba(43,30,22,1)] text-left">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-coffee-900 flex items-center justify-center text-white rotate-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-coffee-900 uppercase tracking-widest text-sm">Bayar Online</h3>
                        <p class="text-[10px] font-mono text-coffee-600 uppercase tracking-widest mt-0.5">QRIS, E-Wallet, Transfer Bank</p>
                    </div>
                </div>
                <div class="text-coffee-900 group-hover:translate-x-1 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </button>

            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t-2 border-dotted border-coffee-900/20"></div>
                <span class="flex-shrink-0 mx-4 text-coffee-400 text-[10px] font-bold uppercase tracking-widest">ATAU</span>
                <div class="flex-grow border-t-2 border-dotted border-coffee-900/20"></div>
            </div>

            <!-- Cash Payment Option -->
            <a href="{{ route('customer.order.status', $order->id) }}" class="w-full group relative flex items-center justify-between p-5 border-2 border-coffee-900 bg-white hover:bg-stone-50 transition-all shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] active:translate-y-0.5 active:shadow-[2px_2px_0px_0px_rgba(43,30,22,1)] text-left">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-coffee-200 flex items-center justify-center text-coffee-900 -rotate-3 border-2 border-coffee-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm17-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-coffee-900 uppercase tracking-widest text-sm">Bayar di Kasir</h3>
                        <p class="text-[10px] font-mono text-coffee-600 uppercase tracking-widest mt-0.5">Bayar tunai langsung di kasir</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('customer.index') }}" class="block w-full text-center py-2 text-[10px] font-bold text-coffee-400 hover:text-coffee-600 transition-colors uppercase tracking-widest">
                Kembali ke Menu
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    // Clear cart on load
    localStorage.removeItem('cart');

    const payButton = document.getElementById('pay-online-btn');
    payButton.addEventListener('click', async function() {
        // ... (script remains same, visual changes mainly)
        payButton.disabled = true;
        const originalContent = payButton.innerHTML;
        // Updated spinner style
        payButton.innerHTML = '<div class="flex items-center justify-center w-full"><svg class="animate-spin h-6 w-6 text-coffee-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';

        try {
            const response = await fetch('{{ route('payment.snap-token', $order->id) }}');
            const data = await response.json();

            if (data.error) {
                alert('Kesalahan Pembayaran: ' + data.error);
                payButton.disabled = false;
                payButton.innerHTML = originalContent;
                return;
            }

            window.snap.pay(data.snap_token, {
                onSuccess: function(result){
                    // Call check endpoint to update status immediately
                    fetch('{{ route('payment.check', $order->id) }}')
                        .then(() => {
                            window.location.href = "{{ route('customer.order.status', $order->id) }}";
                        });
                },
                onPending: function(result){
                     // Call check endpoint to ensure pending status is recorded
                    fetch('{{ route('payment.check', $order->id) }}')
                        .then(() => {
                            window.location.href = "{{ route('customer.order.status', $order->id) }}";
                        });
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    payButton.disabled = false;
                    payButton.innerHTML = originalContent;
                },
                onClose: function(){
                    payButton.disabled = false;
                    payButton.innerHTML = originalContent;
                }
            });
        } catch (error) {
            console.error(error);
            alert('Ada yang salah');
            payButton.disabled = false;
            payButton.innerHTML = originalContent;
        }
    });
</script>
@endpush
@endsection
