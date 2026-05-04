@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-12">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-8 h-0.5 bg-stone-900"></div>
            <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Ringkasan Sistem</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-bold text-stone-900 font-heading uppercase tracking-tight">Dashboard Admin</h1>
        <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mt-4">Selamat datang kembali, {{ Auth::user()->name }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
        <!-- Total Sales -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 hover:shadow-xl transition-all duration-500 group">
            <div class="flex flex-col gap-6">
                <div class="w-12 h-12 rounded-2xl bg-stone-50 flex items-center justify-center text-stone-900 group-hover:bg-stone-900 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em] mb-2">Penjualan Hari Ini</p>
                    <h3 class="text-3xl font-bold text-stone-900 tracking-tight">
                        <span class="text-xs text-stone-400 font-normal mr-1">IDR</span>{{ number_format($stats['total_sales'], 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 hover:shadow-xl transition-all duration-500 group">
            <div class="flex flex-col gap-6">
                <div class="w-12 h-12 rounded-2xl bg-stone-50 flex items-center justify-center text-stone-900 group-hover:bg-stone-900 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em] mb-2">Pesanan Hari Ini</p>
                    <h3 class="text-4xl font-bold text-stone-900 tracking-tight">
                        {{ $stats['total_orders'] }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Active Menus -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 hover:shadow-xl transition-all duration-500 group">
            <div class="flex flex-col gap-6">
                <div class="w-12 h-12 rounded-2xl bg-stone-50 flex items-center justify-center text-stone-900 group-hover:bg-stone-900 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em] mb-2">Menu Aktif</p>
                    <h3 class="text-4xl font-bold text-stone-900 tracking-tight">
                        {{ $stats['active_menus'] }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 hover:shadow-xl transition-all duration-500 group">
            <div class="flex flex-col gap-6">
                <div class="w-12 h-12 rounded-2xl bg-stone-50 flex items-center justify-center text-stone-900 group-hover:bg-stone-900 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em] mb-2">Total Pengguna</p>
                    <h3 class="text-4xl font-bold text-stone-900 tracking-tight">
                        {{ $stats['active_users'] }}
                    </h3>
                </div>
            </div>
        </div>
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
