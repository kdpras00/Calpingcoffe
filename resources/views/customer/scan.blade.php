@extends('layouts.customer')

@section('title', 'Pilih Meja - Calping')

@section('content')
<div class="min-h-screen bg-white py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Sophisticated Background Decor -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-stone-50 rounded-full opacity-50 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[30rem] h-[30rem] bg-stone-50 rounded-full opacity-50 blur-3xl"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-24">
            <div class="flex items-center justify-center gap-4 mb-6">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Langkah Pertama</span>
                <div class="w-8 h-0.5 bg-stone-900"></div>
            </div>
            <h1 class="text-5xl md:text-7xl font-bold text-stone-900 font-heading tracking-tight mb-8 uppercase">Pilih Meja Anda</h1>
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-[0.2em] max-w-sm mx-auto leading-relaxed">
                Silakan pilih meja yang sedang Anda tempati untuk memulai pengalaman memesan yang premium.
            </p>
        </div>

        <!-- 3x3 Table Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 max-w-3xl mx-auto px-4">
            @foreach($tables as $index => $table)
                <form action="{{ route('customer.setTable') }}" method="POST" class="h-full">
                    @csrf
                    <input type="hidden" name="table_number" value="{{ $table->number }}">
                    <button type="submit" {{ $table->is_occupied ? 'disabled' : '' }}
                        class="w-full h-full p-10 border transition-all duration-700 flex flex-col items-center justify-center rounded-[40px] relative group
                        {{ $table->is_occupied 
                            ? 'bg-stone-50 border-stone-50 cursor-not-allowed opacity-50' 
                            : 'bg-white border-stone-100 shadow-sm hover:shadow-2xl hover:shadow-stone-100 hover:-translate-y-4 hover:border-stone-900' }}">
                        
                        <span class="text-[9px] font-bold uppercase tracking-[0.3em] mb-4 {{ $table->is_occupied ? 'text-stone-300' : 'text-stone-400 group-hover:text-stone-900' }}">Table</span>
                        <span class="text-5xl md:text-6xl font-bold font-heading {{ $table->is_occupied ? 'text-stone-200' : 'text-stone-900' }}">{{ $table->number }}</span>
                        
                        <div class="pt-8">
                            @if($table->is_occupied)
                                <div class="px-5 py-2 bg-stone-100 rounded-full text-[8px] font-bold text-stone-400 uppercase tracking-[0.2em] flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-stone-300"></div> OCCUPIED
                                </div>
                            @else
                                <div class="px-5 py-2 bg-stone-900 rounded-full text-[8px] font-bold text-white uppercase tracking-[0.2em] flex items-center gap-2 shadow-lg shadow-stone-200 transition-all group-hover:scale-110">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></div> AVAILABLE
                                </div>
                            @endif
                        </div>
                    </button>
                </form>
            @endforeach
        </div>

        <!-- Back Link -->
        <div class="mt-24 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-4 text-stone-300 hover:text-stone-900 font-bold uppercase tracking-[0.2em] text-[10px] transition-all group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .grid > div {
        animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection
