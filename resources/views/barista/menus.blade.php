@extends('layouts.app')

@section('title', 'Kontrol Stok - Barista')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-12">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Produksi Barista</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-stone-900 font-heading uppercase tracking-tight">Kontrol Stok</h1>
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mt-4">Kelola ketersediaan stok menu</p>
        </div>
    </div>

    <!-- Stock Management Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($menus as $menu)
        <div class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-stone-100 hover:shadow-xl transition-all duration-500 flex flex-col group p-6">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden shrink-0 bg-stone-100 border border-stone-100">
                        <img src="{{ str_starts_with($menu->image, 'http') ? $menu->image : asset('storage/' . $menu->image) }}" 
                             alt="{{ $menu->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-stone-900 text-sm uppercase tracking-tight truncate">{{ $menu->name }}</p>
                        <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-widest {{ $menu->stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $menu->stock > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                </div>
                
                <form action="{{ route('barista.update-stock', $menu) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="number" name="stock" value="{{ $menu->stock }}" min="0" 
                           class="flex-1 px-4 py-3 text-sm font-bold text-center border border-stone-100 rounded-2xl bg-stone-50 text-stone-900 focus:bg-white focus:ring-2 focus:ring-stone-900 focus:border-transparent transition-all">
                    <button type="submit" class="w-12 h-12 bg-stone-900 text-white rounded-2xl hover:bg-stone-800 transition-all flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
