@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex bg-stone-200">
    <!-- Left Side - Image (Poster Style) -->
    <div class="hidden lg:block lg:w-1/2 relative p-12">
        <div class="w-full h-full border-4 border-stone-900 shadow-[12px_12px_0px_0px_rgba(23,23,23,1)] relative overflow-hidden group">
            <img src="{{ asset('img/hero-bg.png') }}" alt="Interior Kafe" class="absolute inset-0 w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0">
            <div class="absolute inset-0 bg-stone-900/20 mix-blend-multiply flex items-center justify-center p-12">
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="bg-white border-4 border-stone-900 p-8 shadow-[12px_12px_0px_0px_rgba(23,23,23,1)]">
                <div class="flex items-center gap-4 mb-8">
                   
                    <div>
                        <h1 class="font-black text-3xl text-stone-900 uppercase tracking-tighter leading-none">CalpingCoffee</h1>
                        <p class="text-[10px] font-mono font-bold text-stone-400 uppercase tracking-widest mt-1">Coffee Management System</p>
                    </div>
                </div>

                <div class="mb-8 border-b-2 border-dotted border-stone-100 pb-6">
                    <h3 class="text-xl font-black text-stone-900 uppercase tracking-tighter">Login Panel</h3>
                    <p class="text-xs font-mono font-bold text-stone-500 uppercase tracking-widest mt-1">Masukkan data akses petugas</p>
                </div>

                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border-2 border-red-500 p-4 shadow-[4px_4px_0px_0px_rgba(239,68,68,1)]">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-[10px] font-mono font-bold text-red-600 uppercase tracking-widest">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="relative">
                        <label for="email" class="absolute -top-2.5 left-3 bg-white px-2 text-[10px] font-mono font-bold text-stone-500 uppercase tracking-widest">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="w-full px-4 py-4 border-2 border-stone-900 bg-white placeholder:text-stone-200 focus:bg-stone-50 outline-none transition-all font-bold text-stone-900"
                               placeholder="user@calping.pos">
                    </div>

                    <div class="relative" x-data="{ show: false }">
                        <label for="password" class="absolute -top-2.5 left-3 bg-white px-2 text-[10px] font-mono font-bold text-stone-500 uppercase tracking-widest">Password</label>
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required 
                               class="w-full px-4 py-4 border-2 border-stone-900 bg-white placeholder:text-stone-200 focus:bg-stone-50 outline-none transition-all font-bold text-stone-900 pr-12"
                               placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-900 transition-colors focus:outline-none">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.076m1.406-1.407A10.014 10.014 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.059 10.059 0 01-4.29 5.766M10.736 10.736L13.264 13.264M14.121 14.121L16.364 16.364M8.121 8.121L5.636 5.636m4.739 4.739L12 12m0 0l2.121 2.121M12 12l2.121-2.121M12 12l-2.121 2.121" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="w-full bg-stone-900 text-white font-black py-5 px-6 uppercase tracking-widest hover:bg-black transition-all shadow-[8px_8px_0px_0px_rgba(23,23,23,0.1)] active:translate-y-1 active:shadow-none">
                        Login Sekarang
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t-2 border-dotted border-stone-100 text-center">
                    <p class="text-[9px] font-mono font-bold text-stone-300 uppercase tracking-widest">
                        Handcrafted for Premium Coffee Experience &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
