@extends('layouts.guest')

@section('title', 'Cerita Kami - CalpingPos')

@section('content')
    <!-- Hero Section (Tuku: Warm & Personal) -->
    <section class="relative py-16 md:py-24 bg-cream-50 overflow-hidden flex items-center min-h-[50vh] md:min-h-[60vh]">
        <div class="absolute inset-0 z-0">
             <!-- abstract shape -->
             <div class="absolute top-0 right-0 w-2/3 h-full bg-coffee-100 rounded-l-[100px] opacity-50"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <span class="text-coffee-600 font-bold tracking-widest uppercase text-sm mb-4 block">Filosofi Kami</span>
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold text-coffee-900 font-heading mb-6 leading-tight">
                    Bukan Sekadar <br>
                    <span class="text-coffee-500">Kedai Kopi.</span>
                </h1>
                <p class="text-base md:text-xl text-coffee-700 leading-relaxed font-medium">
                    Kami adalah ruang tamu bagi warga sekitar. Tempat di mana 'halo' berarti awal dari percakapan panjang, dan setiap cangkir diseduh seperti untuk keluarga sendiri.
                </p>
            </div>
            <div class="md:w-1/2 relative">
                <div class="relative rounded-full overflow-hidden border-[8px] border-white shadow-2xl aspect-square w-full max-w-sm mx-auto rotate-3 hover:-rotate-2 transition-transform duration-700">
                    <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Komunitas Kopi" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Value 1: The Kitchen (Dapur) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 relative">
                    <!-- Polaroid Style Image -->
                    <div class="bg-white p-4 shadow-xl transform -rotate-2 hover:rotate-1 transition-transform duration-500 border border-coffee-100">
                        <img src="{{ asset('img/gallery/galery3.jpg') }}" 
                             alt="Dapur Calping" 
                             class="w-full h-[400px] object-cover grayscale opacity-90 group-hover:grayscale-0 group-hover:opacity-100 transition-all">
                        <div class="mt-4 text-center font-handwriting text-coffee-800 text-lg font-bold">Dapur Calping</div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div class="w-16 h-16 rounded-full bg-coffee-200 flex items-center justify-center text-coffee-800 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-bold text-coffee-900 font-heading mb-4">Racikan Jujur</h2>
                    <p class="text-lg text-coffee-700 leading-relaxed mb-6">
                        Kami tidak punya rahasia. Gula aren asli, susu segar dari peternakan lokal, dan biji kopi yang kami ambil langsung dari petani sahabat. Semuanya transparan, karena kami percaya kejujuran rasa.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Value 2: The Living Room (Ruang Tamu) - Reversed -->
    <section class="py-20 bg-coffee-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row-reverse items-center gap-16">
                 <div class="lg:w-1/2 relative">
                    <!-- Polaroid Style Image -->
                    <div class="bg-white p-4 shadow-xl transform rotate-2 hover:-rotate-1 transition-transform duration-500 border border-coffee-100">
                        <img src="{{ asset('img/gallery/foto-bersama.jpg') }}" 
                             alt="Ruang Tamu" 
                             class="w-full h-[400px] object-cover grayscale opacity-90 group-hover:grayscale-0 group-hover:opacity-100 transition-all">
                        <div class="mt-4 text-center font-handwriting text-coffee-800 text-lg font-bold">Ngumpul Bareng</div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div class="w-16 h-16 rounded-full bg-cream-200 flex items-center justify-center text-coffee-800 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-bold text-coffee-900 font-heading mb-4">Ruang Tamu Bersama</h2>
                    <p class="text-lg text-coffee-700 leading-relaxed mb-6">
                        Mau kerja remote? Silakan. Mau gosip sore? Boleh banget. Atau cuma mau bengong lihat hujan? Kami sediakan kursinya. Di sini, tidak ada orang asing, yang ada hanya teman yang belum kenalan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-coffee-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-10 pattern-grid-lg"></div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold text-cream-100 font-heading mb-8">Jadi Bagian dari Cerita Kami?</h2>
            <p class="text-xl text-cream-200 mb-10 leading-relaxed">
                Pintu kami selalu terbuka. Datanglah kapan saja, kami seduhkan yang terbaik.
            </p>
            <a href="{{ route('customer.index') }}" class="inline-block px-10 py-4 rounded-full bg-cream-100 text-coffee-900 font-bold text-lg shadow-xl transition-all hover:-translate-y-1 hover:shadow-2xl hover:bg-white uppercase tracking-widest">
                Yuk, Mampir!
            </a>
        </div>
    </section>
@endsection
