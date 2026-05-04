@extends('layouts.customer')
@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white px-4 py-16">
    <div class="max-w-md w-full space-y-12">
        
        <!-- Header Section -->
        <div class="text-center">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Pilih Pembayaran</span>
                <div class="w-8 h-0.5 bg-stone-900"></div>
            </div>
            
            <div class="mx-auto w-24 h-24 bg-stone-50 rounded-full border border-stone-100 flex items-center justify-center mb-8 shadow-sm">
                <svg class="w-10 h-10 text-stone-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h1 class="text-5xl font-bold font-heading text-stone-900 uppercase tracking-tight mb-2">Pesanan Dibuat!</h1>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">ORDER <span class="text-stone-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></p>
        </div>
        
        <!-- Total Card (Receipt Style) -->
        <div class="bg-white rounded-[32px] p-10 border-2 border-dashed border-stone-200 shadow-[0_20px_50px_rgba(0,0,0,0.05)] relative mx-4 transition-all duration-700">
            <!-- Cutout circles for receipt effect -->
            <div class="absolute -left-6 top-1/2 w-8 h-8 bg-white rounded-full border-r-2 border-dashed border-stone-200 transform -translate-y-1/2"></div>
            <div class="absolute -right-6 top-1/2 w-8 h-8 bg-white rounded-full border-l-2 border-dashed border-stone-200 transform -translate-y-1/2"></div>
            
            <div class="flex flex-col items-center relative z-10">
                <span class="text-[9px] font-bold text-stone-400 uppercase tracking-[0.4em] mb-4">Total Pembayaran</span>
                <div class="text-5xl font-bold font-heading text-stone-900 tracking-tighter">
                    <span class="text-xs font-normal text-stone-400 mr-1">IDR</span>{{ number_format($order->total_amount, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Payment Options -->
        <div class="space-y-6 pt-4">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.4em]">Opsi Pembayaran</span>
            </div>

            <!-- Online Payment Option -->
            <button id="pay-online-btn" class="w-full group relative flex items-center justify-between p-8 rounded-[32px] bg-white border border-stone-100 hover:border-stone-900 hover:shadow-2xl hover:shadow-stone-100 transition-all duration-500 text-left overflow-hidden">
                <div class="flex items-center gap-6 relative z-10">
                    <div class="w-16 h-16 bg-stone-900 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-stone-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-stone-900 uppercase tracking-widest text-sm mb-1">Bayar Online</h3>
                        <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest leading-relaxed">QRIS, E-Wallet, Virtual Account</p>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-full bg-stone-50 flex items-center justify-center group-hover:bg-stone-900 group-hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </button>

            <!-- Cash Payment Option -->
            <a href="{{ route('customer.order.status', $order->id) }}" class="w-full group relative flex items-center justify-between p-8 rounded-[32px] bg-stone-50 border border-stone-50 hover:bg-white hover:border-stone-200 transition-all duration-500 text-left">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-white rounded-2xl border border-stone-100 flex items-center justify-center text-stone-900">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm17-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-stone-900 uppercase tracking-widest text-sm mb-1">Bayar Tunai</h3>
                        <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest leading-relaxed">Selesaikan pembayaran di kasir</p>
                    </div>
                </div>
            </a>
            
            <div class="text-center pt-8">
                <a href="{{ route('customer.index') }}" class="inline-flex items-center gap-4 text-stone-300 hover:text-stone-900 font-bold uppercase tracking-[0.2em] text-[9px] transition-all group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Menu
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    localStorage.removeItem('cart');

    const payButton = document.getElementById('pay-online-btn');
    payButton.addEventListener('click', async function() {
        payButton.disabled = true;
        const originalContent = payButton.innerHTML;
        payButton.innerHTML = '<div class="flex items-center justify-center w-full"><svg class="animate-spin h-6 w-6 text-stone-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';

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
                    fetch('{{ route('payment.check', $order->id) }}')
                        .then(() => {
                            window.location.href = "{{ route('customer.order.status', $order->id) }}";
                        });
                },
                onPending: function(result){
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
            alert('Terjadi kesalahan sistem');
            payButton.disabled = false;
            payButton.innerHTML = originalContent;
        }
    });
</script>
@endpush
@endsection
