@extends('layouts.guest')

@section('title', 'Calping Coffee - Kopi Pilihan Anda')

@section('content')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
<style>
    @keyframes float-up {
        from { opacity: 0; transform: translateY(32px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up-1 { animation: float-up 0.8s 0.1s ease both; }
    .fade-up-2 { animation: float-up 0.8s 0.3s ease both; }
    .fade-up-3 { animation: float-up 0.8s 0.5s ease both; }
    .fade-up-4 { animation: float-up 0.8s 0.7s ease both; }

    @keyframes ticker-kiri {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .ticker-track { animation: ticker-kiri 20s linear infinite; }

    @keyframes float-gentle {
        0%, 100% { transform: translateY(0px) rotate(-1deg); }
        50%       { transform: translateY(-8px) rotate(-1deg); }
    }
    .float-card-1 { animation: float-gentle 4s 0s ease-in-out infinite; }
    .float-card-2 { animation: float-gentle 4.5s 0.8s ease-in-out infinite; }
    .float-card-3 { animation: float-gentle 5s 1.4s ease-in-out infinite; }

    .reveal {
        opacity: 0; transform: translateY(32px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.in { opacity: 1; transform: translateY(0); }
    
    .grain {
        position: absolute; inset: 0; pointer-events: none; opacity: 0.06;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    }
</style>
@endpush

{{-- ══════════════════════════════════
     HERO
══════════════════════════════════ --}}
<section id="hero-sequence" class="relative overflow-hidden min-h-screen flex items-center bg-[#bda897]">
    {{-- Canvas Sequence --}}
    <canvas id="sequence-canvas" class="absolute inset-0 w-full h-full object-cover pointer-events-none"></canvas>
    
    {{-- Dark overlay (optional, dikurangi agar gambar 3D sequence lebih jelas) --}}
    <div class="absolute inset-0 bg-black/10 pointer-events-none"></div>
    <div class="grain z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 w-full pt-8 pb-16 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        {{-- LEFT: Text --}}
        <div>
            {{-- Label --}}
            <div class="fade-up-1 inline-flex items-center gap-3 mb-8">
                <div class="w-8 h-0.5 bg-white"></div>
                <span class="font-mono text-xs uppercase tracking-[0.3em] text-white/80 font-bold">Coffee Shop</span>
            </div>

            {{-- Headline --}}
            <h1 class="fade-up-2 font-bold text-white leading-[0.88]"
                style="font-family: 'Playfair Display', serif; font-size: clamp(60px, 10vw, 120px);">
                CALPING<br>
                <span class="italic font-normal" style="font-size: 0.6em; color: rgba(255,255,255,0.6);">— Coffee —</span>
            </h1>

            {{-- Desc --}}
            <p class="fade-up-3 mt-8 text-white/70 font-mono text-sm leading-relaxed max-w-sm">
                Setiap tegukan adalah perjalanan.<br>
                Pilih mejamu, pilih favoritmu,<br>
                dan nikmati momen terbaik hari ini.
            </p>
        </div>
    </div>
</section>

<div class="bg-coffee-900 py-3.5 overflow-hidden border-y-2 border-coffee-900">
    <div class="ticker-track flex gap-0 whitespace-nowrap" style="width: max-content;">
        @for($i = 0; $i < 2; $i++)
            @foreach(['☕ Freshly Brewed', '✦ Kopi Lokal', '☕ Single Origin', '✦ Barista Choice', '☕ Calping Coffee', '✦ Rasa Autentik', '☕ Nikmati Momen'] as $t)
                <span class="inline-block px-8 text-white font-mono text-xs uppercase tracking-widest font-bold opacity-80">{{ $t }}</span>
            @endforeach
        @endfor
    </div>
</div>

<section class="bg-coffee-200 py-28 relative overflow-hidden">
    <div class="grain"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        {{-- Image --}}
        <div class="reveal relative">
            <div class="relative border-2 border-coffee-900 shadow-[16px_16px_0px_0px_rgba(43,30,22,1)] overflow-hidden -rotate-1 hover:rotate-0 transition-transform duration-500">
                <img src="{{ asset('img/calping-bg.png') }}" class="w-full aspect-[4/3] object-cover object-bottom">
                <div class="absolute inset-0 bg-gradient-to-t from-coffee-900/50 via-transparent to-transparent"></div>
                {{-- Live badge --}}
                <div class="absolute bottom-4 left-4 flex items-center gap-2 bg-white border-2 border-coffee-900 px-4 py-2 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="font-mono text-coffee-900 text-[10px] uppercase tracking-widest font-bold">Open Now</span>
                </div>
            </div>
        </div>

        {{-- Text --}}
        <div class="reveal">
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="w-8 h-0.5 bg-coffee-900"></div>
                <span class="font-mono text-xs uppercase tracking-[0.3em] text-coffee-700 font-bold">Tentang Kami</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-coffee-900 leading-tight mb-6"
                style="font-family: 'Playfair Display', serif;">
                Kopi yang<br><em>Bercerita</em>
            </h2>
            <p class="text-coffee-700 font-mono text-sm leading-relaxed mb-6">
                Di Calping, setiap cangkir dibuat dengan perhatian dan cinta. Kami percaya kopi yang baik bukan sekadar minuman — ia adalah momen, percakapan, dan kenangan.
            </p>
            <p class="text-coffee-700/60 font-mono text-sm leading-relaxed mb-10">
                Dari biji kopi lokal pilihan terbaik hingga sajian yang memuaskan selera, semua hadir untuk menemani hari-harimu.
            </p>
            <a href="{{ route('ourstory') }}"
               class="group inline-flex items-center gap-3 px-6 py-3 bg-white border-2 border-coffee-900 font-bold text-coffee-900 text-xs uppercase tracking-widest shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
                Baca Cerita Kami
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>


<section class="bg-coffee-200 py-24 border-t-2 border-coffee-900/10 relative overflow-hidden">
    <div class="grain"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

        <div class="reveal flex flex-col md:flex-row justify-between items-end gap-6 mb-14">
            <div>
                <div class="inline-flex items-center gap-3 mb-4">
                    <div class="w-8 h-0.5 bg-coffee-900"></div>
                    <span class="font-mono text-xs uppercase tracking-[0.3em] text-coffee-700 font-bold">Dari Dapur Kami</span>
                </div>
                <h2 class="text-5xl md:text-6xl font-black text-coffee-900 leading-tight"
                    style="font-family: 'Playfair Display', serif;">
                    Menu<br><em>Favorit</em>
                </h2>
            </div>
            <a href="{{ route('customer.scan') }}"
               class="group inline-flex items-center gap-2 font-mono text-xs uppercase tracking-widest text-coffee-700 hover:text-coffee-900 border-b border-coffee-700/30 hover:border-coffee-900 pb-0.5 transition-all">
                Lihat Semua Menu
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="reveal grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-14">
            @foreach($highlights as $i => $item)
            <div class="group {{ $i === 1 ? 'md:mt-10' : '' }}">
                <div class="relative bg-white border-2 border-coffee-900 p-4 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] transition-all duration-300 group-hover:shadow-[18px_18px_0px_0px_rgba(43,30,22,1)] group-hover:-translate-y-2 {{ $i % 2 == 0 ? '-rotate-1' : 'rotate-2' }} group-hover:rotate-0">
                    {{-- Badge --}}
                    <div class="absolute -top-3 -right-3 bg-tuku-mustard text-white text-[9px] font-bold px-3 py-1 border-2 border-coffee-900 rotate-6 shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                        {{ $i == 0 ? 'MONTHLY BEST' : ($i == 1 ? 'FAVORITE' : 'TOP RATED') }}
                    </div>
                    {{-- Image --}}
                    <div class="border-2 border-coffee-900 overflow-hidden mb-4 bg-coffee-100" style="aspect-ratio: 4/5;">
                        <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                             class="w-full h-full object-cover grayscale-[0.15] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500">
                    </div>
                    {{-- Category badge on image corner --}}
                    <p class="font-mono text-[9px] uppercase tracking-widest text-coffee-500 mb-1">{{ $item->category->name ?? 'Menu' }}</p>
                    <h3 class="text-xl font-black text-coffee-900 mb-2 uppercase tracking-tighter">{{ $item->name }}</h3>
                    <p class="font-mono text-xs text-coffee-700/70 leading-relaxed">{{ Str::limit($item->description, 60) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="bg-white py-24 border-t-2 border-coffee-900 relative overflow-hidden">
    <div class="grain"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

        <div class="reveal mb-12">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="w-8 h-0.5 bg-coffee-900"></div>
                <span class="font-mono text-xs uppercase tracking-[0.3em] text-coffee-700 font-bold">Momen Kita</span>
            </div>
            <h2 class="text-5xl font-black text-coffee-900" style="font-family: 'Playfair Display', serif;">
                #CalpingStory
            </h2>
        </div>

        @php $galleryImages = ['galery1.jpg', 'galery2.jpg', 'galery3.jpg', 'galery4.jpg', 'galery5.jpg', 'galery6.jpg']; @endphp

        <div class="reveal grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($galleryImages as $i => $img)
            <div class="group relative overflow-hidden border-2 border-coffee-900 {{ $i === 2 ? 'md:row-span-2' : '' }} shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:shadow-[8px_8px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all duration-300"
                 style="{{ $i === 2 ? 'aspect-ratio: 3/5;' : 'aspect-ratio: 4/3;' }}">
                <img src="{{ asset('img/gallery/' . $img) }}" alt="Gallery"
                     class="w-full h-full object-cover grayscale-[0.15] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="bg-coffee-900 py-32 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=40 height=40 viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23FFFFFF\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E')"></div>
    <div class="grain"></div>

    <div class="relative z-10 max-w-2xl mx-auto text-center px-6">
        <h2 class="text-5xl md:text-6xl font-black text-white leading-tight mb-6"
            style="font-family: 'Playfair Display', serif;">
            Siap Menikmati<br>
            <em class="text-tuku-mustard">Momen Hari Ini?</em>
        </h2>
        <p class="text-white/50 font-mono text-sm leading-relaxed mb-10 max-w-sm mx-auto">
            Pilih mejamu, pesan favoritmu, dan biarkan aroma kopi membawa momen terbaikmu.
        </p>
        <a href="{{ route('customer.scan') }}"
           class="group inline-flex items-center gap-3 px-10 py-5 bg-tuku-mustard text-coffee-900 font-bold text-xs uppercase tracking-widest border-2 border-white/20 shadow-[8px_8px_0px_0px_rgba(229,161,36,0.3)] hover:shadow-[14px_14px_0px_0px_rgba(229,161,36,0.2)] hover:-translate-y-1 transition-all">
            <span>Mulai Pesan Sekarang</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

// --- GSAP IMAGE SEQUENCE ---
gsap.registerPlugin(ScrollTrigger);

const canvas = document.getElementById("sequence-canvas");
if (canvas) {
    const context = canvas.getContext("2d");
    
    // Set resolusi canvas. Gunakan ukuran standar untuk performa
    canvas.width = 1280; 
    canvas.height = 720;
    
    const frameCount = 240;
    const currentFrame = index => `{{ asset('img/sequence/ezgif-frame-') }}${(index + 1).toString().padStart(3, '0')}.jpg`;
    
    const images = [];
    const seq = { frame: 0 };
    
    for (let i = 0; i < frameCount; i++) {
        const img = new Image();
        img.src = currentFrame(i);
        images.push(img);
    }
    
    images[0].onload = render;
    
    function render() {
        context.clearRect(0, 0, canvas.width, canvas.height);
        const img = images[seq.frame];
        if(!img || !img.complete) return;
        
        // Memastikan gambar menutupi seluruh canvas (object-fit: cover)
        const hRatio = canvas.width / img.width;
        const vRatio = canvas.height / img.height;
        const ratio  = Math.max(hRatio, vRatio);
        const centerShift_x = (canvas.width - img.width * ratio) / 2;
        const centerShift_y = (canvas.height - img.height * ratio) / 2;  
        
        context.drawImage(img, 0,0, img.width, img.height,
                          centerShift_x, centerShift_y, img.width * ratio, img.height * ratio);
    }
    
    gsap.to(seq, {
        frame: frameCount - 1,
        snap: "frame",
        ease: "none",
        scrollTrigger: {
            trigger: "#hero-sequence",
            start: "top top",
            end: "+=100%", // Animasi berlaku selama 1x tinggi layar agar lebih cepat/singkat
            scrub: 0.5, // Smoothing untuk scroll
            pin: true,
        },
        onUpdate: render
    });
    
    window.addEventListener('resize', () => {
        render(); 
    });
}
</script>
@endpush

@endsection
