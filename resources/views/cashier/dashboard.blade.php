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
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mt-4">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Empty State / Welcome -->
    <div class="py-32 flex flex-col items-center justify-center gap-6 bg-white rounded-[40px] border border-stone-100 shadow-sm border-dashed">
        <div class="w-24 h-24 rounded-full bg-stone-50 flex items-center justify-center text-stone-200">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="text-center max-w-md mx-auto">
            <h3 class="text-xl font-bold text-stone-900 font-heading uppercase tracking-widest mb-2">Selamat Bertugas</h3>
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest leading-relaxed">Silakan gunakan menu navigasi di samping untuk mengelola transaksi penjualan dan status meja.</p>
        </div>
    </div>
</div>
@endsection
