@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex bg-coffee-200">
    <!-- Left Side - Image (Poster Style) -->
    <div class="hidden lg:block lg:w-1/2 relative p-12">
        <div class="w-full h-full border-4 border-coffee-900 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] relative overflow-hidden group">
            <img src="{{ asset('img/hero-bg.png') }}" alt="Interior Kafe" class="absolute inset-0 w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0">
            <div class="absolute inset-0 bg-coffee-900/20 mix-blend-multiply flex items-center justify-center p-12">
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="bg-white border-4 border-coffee-900 p-8 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)]">
                <div class="flex items-center gap-4 mb-8">
                   
                    <div>
                        <h1 class="font-black text-3xl text-coffee-900 uppercase tracking-tighter leading-none">CalpingCoffee</h1>
                        <p class="text-[10px] font-mono font-bold text-coffee-400 uppercase tracking-widest mt-1">Coffee Management System</p>
                    </div>
                </div>

                <div class="mb-8 border-b-2 border-dotted border-coffee-100 pb-6">
                    <h3 class="text-xl font-black text-coffee-900 uppercase tracking-tighter">Login Panel</h3>
                    <p class="text-xs font-mono font-bold text-coffee-500 uppercase tracking-widest mt-1">Masukkan data akses petugas</p>
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
                        <label for="email" class="absolute -top-2.5 left-3 bg-white px-2 text-[10px] font-mono font-bold text-coffee-500 uppercase tracking-widest">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="w-full px-4 py-4 border-2 border-coffee-900 bg-white placeholder:text-coffee-200 focus:bg-coffee-50 outline-none transition-all font-bold text-coffee-900"
                               placeholder="user@calping.pos">
                    </div>

                    <div class="relative">
                        <label for="password" class="absolute -top-2.5 left-3 bg-white px-2 text-[10px] font-mono font-bold text-coffee-500 uppercase tracking-widest">Safe Password</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-4 border-2 border-coffee-900 bg-white placeholder:text-coffee-200 focus:bg-coffee-50 outline-none transition-all font-bold text-coffee-900"
                               placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full bg-coffee-900 text-white font-black py-5 px-6 uppercase tracking-widest hover:bg-black transition-all shadow-[8px_8px_0px_0px_rgba(229,161,36,0.3)] active:translate-y-1 active:shadow-none">
                        Login Sekarang
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t-2 border-dotted border-coffee-100 text-center">
                    <p class="text-[9px] font-mono font-bold text-coffee-300 uppercase tracking-widest">
                        Handcrafted for Premium Coffee Experience &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
