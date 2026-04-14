@extends('layouts.customer')

@section('title', 'Pilih Meja - Calping')

@section('content')
<div class="min-h-screen bg-coffee-200 py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-tuku-mustard rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-coffee-900 rounded-full opacity-10 blur-3xl"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-bold text-coffee-900 font-heading tracking-tight mb-4 drop-shadow-sm uppercase">Pilih Meja Anda</h1>
            <div class="inline-block bg-coffee-900 text-white px-6 py-1.5 rounded-full text-xs font-mono font-bold uppercase tracking-widest shadow-[4px_4px_0px_0px_rgba(229,161,36,1)]">
                Area Coffee Shop
            </div>
            <p class="mt-8 text-coffee-700 font-mono text-sm max-w-md mx-auto leading-relaxed">
                Pilih meja yang Anda tempati. Klik pada meja yang <strong>Tersedia</strong> untuk melanjutkan pesanan.
            </p>
        </div>

        <!-- 3x3 Table Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-8 max-w-3xl mx-auto px-4 relative">
            
            <!-- Optional: Decor Arrows if you want it to look exactly like the center map, but let's stick to a solid layout first -->
            @foreach($tables as $index => $table)
                <form action="{{ route('customer.setTable') }}" method="POST" class="group h-full">
                    @csrf
                    <input type="hidden" name="table_number" value="{{ $table->number }}">
                    <button type="submit" {{ $table->is_occupied ? 'disabled' : '' }}
                        class="w-full h-full p-6 md:p-8 border-2 transition-all duration-300 flex flex-col items-center justify-center space-y-3 rounded-2xl
                        {{ $table->is_occupied 
                            ? 'bg-stone-100 border-stone-300 cursor-not-allowed opacity-80' 
                            : 'bg-white border-coffee-900 shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] hover:shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-2' }}">
                        
                        <span class="{{ $table->is_occupied ? 'text-stone-400' : 'text-coffee-600' }} font-mono text-xs uppercase font-bold tracking-widest">Meja</span>
                        <span class="text-4xl md:text-5xl font-bold {{ $table->is_occupied ? 'text-stone-400' : 'text-coffee-900' }} font-heading">{{ $table->number }}</span>
                        
                        <div class="pt-4">
                            @if($table->is_occupied)
                                <div class="px-4 py-1.5 bg-red-50 border border-red-200 rounded-full text-[10px] font-mono font-bold text-red-600 uppercase tracking-widest flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> PENUH
                                </div>
                            @else
                                <div class="px-4 py-1.5 bg-green-50 border border-green-200 rounded-full text-[10px] font-mono font-bold text-green-600 uppercase tracking-widest flex items-center gap-1 group-hover:bg-green-600 group-hover:text-white group-hover:border-green-600 transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 group-hover:bg-white"></span> TERSEDIA
                                </div>
                            @endif
                        </div>
                    </button>
                </form>
            @endforeach
        </div>

        <!-- Back Link -->
        <div class="mt-20 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-coffee-900 font-bold text-sm hover:underline group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                KEMBALI KE HALAMAN UTAMA
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .grid > div {
        animation: fade-in-up 0.5s ease-out forwards;
    }
</style>
@endsection
