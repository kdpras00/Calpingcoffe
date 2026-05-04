@extends('layouts.customer')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white px-4">
    <div class="max-w-md w-full text-center space-y-10">
        
        <!-- Header -->
        <div class="text-center">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Akses Terbatas</span>
                <div class="w-8 h-0.5 bg-stone-900"></div>
            </div>
            
            <div class="relative mx-auto w-24 h-24 mb-8">
                <div class="absolute inset-0 bg-red-100 rounded-full animate-ping opacity-75"></div>
                <div class="relative w-full h-full bg-white rounded-full border border-stone-100 flex items-center justify-center shadow-lg animate-pulse">
                    <svg class="w-10 h-10 text-stone-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-5xl font-bold font-heading text-stone-900 uppercase tracking-tight mb-4">MEJA TERPAKAI</h1>
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-[0.2em] leading-relaxed max-w-xs mx-auto">
                Maaf, meja ini sedang melayani pelanggan lain. Silakan pilih meja lain atau hubungi staf kami.
            </p>
        </div>

        <!-- Action -->
        <div class="pt-4">
            <a href="{{ route('customer.scan') }}" class="inline-flex items-center gap-6 bg-stone-900 text-white px-10 py-5 rounded-full font-bold text-[10px] uppercase tracking-[0.3em] shadow-2xl shadow-stone-200 hover:bg-stone-800 transition-all group">
                Scan Meja Lain
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:translate-x-2 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </a>
        </div>

        <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest pt-8">
            CalpingCoffee - Premium Experience
        </p>
    </div>
</div>
@endsection
