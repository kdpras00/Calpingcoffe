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

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
        <x-stat-card 
            title="Menunggu Pembayaran" 
            value="{{ $stats['pending_orders'] }}" 
            color="amber">
            <x-slot name="icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card 
            title="Pesanan Dibayar Hari Ini" 
            value="{{ $stats['paid_orders_today'] }}" 
            color="indigo">
            <x-slot name="icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card 
            title="Total Penjualan Hari Ini" 
            value="{{ number_format($stats['income_today'], 0, ',', '.') }}" 
            color="emerald" 
            :isCurrency="true">
            <x-slot name="icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card 
            title="Meja Terisi" 
            value="{{ $stats['active_tables'] }}" 
            color="stone">
            <x-slot name="icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </x-slot>
        </x-stat-card>
    </div>

    <!-- Recent Orders History -->
    <div class="bg-white rounded-[40px] p-10 shadow-sm border border-stone-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <h2 class="text-3xl font-bold text-stone-900 font-heading uppercase tracking-tight">Riwayat Pesanan Terbaru</h2>
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Update Real-time</span>
            </div>
        </div>
        
        <div class="overflow-x-auto -mx-10 md:mx-0">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em] border-b border-stone-100">
                        <th class="pb-6 px-6">ID Pesanan</th>
                        <th class="pb-6 px-6">Meja</th>
                        <th class="pb-6 px-6">Detail Pesanan</th>
                        <th class="pb-6 px-6 text-right">Total Bayar</th>
                        <th class="pb-6 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-stone-50">
                    @forelse($recentOrders as $recentOrder)
                    <tr class="hover:bg-stone-50/50 transition-colors group">
                        <td class="py-8 px-6">
                            <div class="font-bold text-stone-900 mb-1">#{{ str_pad($recentOrder->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-[10px] font-semibold text-stone-400 uppercase tracking-widest">{{ $recentOrder->created_at->format('H:i') }} • {{ $recentOrder->created_at->format('d M') }}</div>
                        </td>
                        <td class="py-8 px-6">
                            <span class="inline-flex items-center px-4 py-1.5 bg-stone-900 text-white text-[9px] font-bold uppercase tracking-widest rounded-full">
                                {{ $recentOrder->table ? 'MEJA ' . $recentOrder->table->number : 'Lainnya' }}
                            </span>
                        </td>
                        <td class="py-8 px-6">
                            <div class="flex flex-wrap gap-2">
                                @foreach($recentOrder->items as $item)
                                <div class="flex items-center gap-2 bg-stone-50 border border-stone-100 px-3 py-1 rounded-lg">
                                    <span class="text-[10px] font-black text-stone-900">{{ $item->quantity }}x</span>
                                    <span class="text-[11px] font-semibold text-stone-600 uppercase tracking-tight">
                                        {{ $item->menu ? $item->menu->name : 'Menu Terhapus' }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-8 px-6 text-right">
                            <div class="font-bold text-stone-900 text-base">
                                <span class="text-[10px] text-stone-400 font-normal mr-1">IDR</span>{{ number_format($recentOrder->total_amount, 0, ',', '.') }}
                            </div>
                            <div class="text-[9px] font-bold uppercase tracking-widest mt-1 {{ $recentOrder->payment_status === 'paid' ? 'text-green-500' : 'text-stone-400' }}">
                                {{ $recentOrder->payment_status }}
                            </div>
                        </td>
                        <td class="py-8 px-6 text-center">
                            @if($recentOrder->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-green-50 text-green-600 text-[9px] font-bold uppercase tracking-widest">
                                    <div class="w-1 h-1 rounded-full bg-green-600"></div>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-stone-100 text-stone-400 text-[9px] font-bold uppercase tracking-widest">
                                    <div class="w-1 h-1 rounded-full bg-stone-400"></div>
                                    {{ $recentOrder->status }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 px-6 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-stone-50 flex items-center justify-center text-stone-200">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <p class="text-xs font-bold text-stone-400 uppercase tracking-widest">Belum ada transaksi hari ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
