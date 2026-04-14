@extends('layouts.customer')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <div class="w-24 h-24 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-6 animate-pulse">
        <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
        </svg>
    </div>
    
    <h1 class="text-2xl font-bold text-stone-800 dark:text-stone-100 mb-2">Meja Sedang Digunakan</h1>
    <p class="text-stone-500 dark:text-stone-400 max-w-xs mx-auto mb-8">
        Maaf, meja ini sedang melayani pelanggan lain. Silakan hubungi staf kami jika ini adalah kesalahan.
    </p>

    <a href="{{ route('customer.scan') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-stone-900 hover:bg-stone-800 transition-colors">
        Scan Meja Lain
    </a>
</div>
@endsection
