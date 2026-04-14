@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-4xl font-black text-coffee-900 uppercase tracking-tighter">Dashboard Admin</h1>
        <p class="text-xs font-mono font-bold text-coffee-600 uppercase tracking-widest mt-1">Selamat datang kembali, {{ Auth::user()->name }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <!-- Total Sales -->
        <div class="bg-white border-2 border-coffee-900 p-6 shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] hover:shadow-[10px_10px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-mono font-bold text-coffee-500 uppercase tracking-widest">Penjualan Hari Ini</p>
                    <h3 class="text-2xl font-black text-coffee-900 mt-2 font-heading">
                        Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-3 bg-green-500 border-2 border-coffee-900 shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-tuku-mustard/10 border-2 border-coffee-900 p-6 shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] hover:shadow-[10px_10px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-mono font-bold text-coffee-500 uppercase tracking-widest">Pesanan Hari Ini</p>
                    <h3 class="text-3xl font-black text-coffee-900 mt-2 font-heading">
                        {{ $stats['total_orders'] }}
                    </h3>
                </div>
                <div class="p-3 bg-coffee-900 border-2 border-coffee-900 shadow-[2px_2px_0px_0px_rgba(229,161,36,1)]">
                    <svg class="w-8 h-8 text-tuku-mustard" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Menus -->
        <div class="bg-white border-2 border-coffee-900 p-6 shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] hover:shadow-[10px_10px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-mono font-bold text-coffee-500 uppercase tracking-widest">Menu Aktif</p>
                    <h3 class="text-3xl font-black text-coffee-900 mt-2 font-heading">
                        {{ $stats['active_menus'] }}
                    </h3>
                </div>
                <div class="p-3 bg-tuku-mustard border-2 border-coffee-900 shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                    <svg class="w-8 h-8 text-coffee-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white border-2 border-coffee-900 p-6 shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] hover:shadow-[10px_10px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-mono font-bold text-coffee-500 uppercase tracking-widest">Total Pengguna</p>
                    <h3 class="text-3xl font-black text-coffee-900 mt-2 font-heading">
                        {{ $stats['active_users'] }}
                    </h3>
                </div>
                <div class="p-3 bg-coffee-200 border-2 border-coffee-900 shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                    <svg class="w-8 h-8 text-coffee-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders History -->
    <div class="bg-white border-4 border-coffee-900 p-8 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] -rotate-1">
        <div class="flex items-center justify-between mb-8 border-b-2 border-dotted border-coffee-900/30 pb-4">
            <h2 class="text-2xl font-black text-coffee-900 uppercase tracking-tighter">Riwayat Pesanan Terbaru</h2>
            <div class="w-12 h-1 border-t-2 border-coffee-900"></div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-coffee-900 text-xs font-mono font-bold text-coffee-500 uppercase tracking-widest">
                        <th class="pb-4 px-4">Order ID / Waktu</th>
                        <th class="pb-4 px-4">Meja</th>
                        <th class="pb-4 px-4">Menu yang Dibeli</th>
                        <th class="pb-4 px-4 text-right">Total Bayar</th>
                        <th class="pb-4 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y-2 divide-coffee-100">
                    @forelse($recentOrders as $recentOrder)
                    <tr class="hover:bg-coffee-50 transition-colors group">
                        <td class="py-5 px-4 align-top">
                            <div class="font-black text-coffee-900 text-base">#{{ str_pad($recentOrder->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-[10px] font-mono font-bold text-coffee-400 uppercase tracking-widest mt-1">{{ $recentOrder->created_at->format('M d, H:i') }}</div>
                        </td>
                        <td class="py-5 px-4 align-top">
                            <span class="inline-block px-3 py-1 bg-coffee-900 text-white text-[10px] font-mono font-bold uppercase tracking-widest border border-coffee-900">
                                {{ $recentOrder->table ? 'Meja ' . $recentOrder->table->number : 'Lainnya' }}
                            </span>
                        </td>
                        <td class="py-5 px-4 align-top">
                            <ul class="space-y-2">
                                @foreach($recentOrder->items as $item)
                                <li class="text-coffee-700 font-bold text-xs flex items-start gap-2">
                                    <span class="bg-coffee-100 text-coffee-900 px-1.5 py-0.5 border border-coffee-900 text-[10px] font-black">{{ $item->quantity }}x</span>
                                    <span class="uppercase tracking-tight">
                                        {{ $item->menu ? $item->menu->name : 'Menu Terhapus' }}
                                        @if($item->note)
                                            <br><span class="text-[9px] font-mono text-tuku-mustard italic font-medium normal-case">"{{ $item->note }}"</span>
                                        @endif
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="py-5 px-4 align-top text-right">
                            <div class="font-black text-coffee-900 text-base font-heading">
                                Rp {{ number_format($recentOrder->total_amount, 0, ',', '.') }}
                            </div>
                            <div class="text-[10px] font-mono font-bold text-coffee-400 uppercase tracking-widest mt-1">
                                {{ $recentOrder->payment_status }}
                            </div>
                        </td>
                        <td class="py-5 px-4 align-top text-center">
                            @if($recentOrder->status === 'completed')
                                <span class="inline-block px-3 py-1 bg-green-500 text-white text-[10px] font-black uppercase tracking-widest border-2 border-coffee-900 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    Selesai
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-red-500 text-white text-[10px] font-black uppercase tracking-widest border-2 border-coffee-900 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    Batal
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 px-4 text-center font-mono text-coffee-400 uppercase tracking-widest text-xs">
                            Belum ada riwayat transaksi hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
