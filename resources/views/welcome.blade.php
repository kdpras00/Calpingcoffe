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
    #hero-hand {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        backface-visibility: hidden;
    }
</style>
@endpush


<section id="hero-banner" class="relative overflow-hidden bg-stone-950 md:min-h-screen flex flex-col md:block">

    <div class="relative w-full md:absolute md:inset-0 md:h-full">
        <img src="{{ asset('img/banner-hero.jpg') }}?v={{ time() }}" id="hero-bg" 
             class="w-full h-auto md:h-full md:object-cover object-center">
    </div>
    
    {{-- Hand Image (Floating) --}}
    <div class="absolute inset-0 pointer-events-none z-20 perspective-1000" id="hero-hand-wrapper">
        <img src="{{ asset('img/tangan.png') }}?v={{ time() }}" id="hero-hand" class="w-full h-full object-contain md:object-cover object-bottom transform-gpu origin-bottom">
    </div>

    {{-- Huge Background Text --}}
    <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none select-none overflow-hidden">
        <h1 class="text-[26vw] font-black text-white/80 uppercase tracking-tighter leading-none hidden md:block">
            CALPING
        </h1>
    </div>

    {{-- Subtle Overlay --}}
    <div class="absolute inset-0 bg-black/10 pointer-events-none z-10"></div>
    <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-black/60 to-transparent pointer-events-none z-10"></div>
    <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-black/40 to-transparent pointer-events-none z-10 md:hidden"></div>
    <div class="grain z-10 opacity-5"></div>
</section>

<div class="bg-stone-900 py-4 overflow-hidden">
    <div class="ticker-track flex gap-0 whitespace-nowrap" style="width: max-content;">
        @for($i = 0; $i < 3; $i++)
            @foreach(['☕ Freshly Brewed', '✦ Kopi Lokal', '☕ Single Origin', '✦ Barista Choice', '☕ Calping Coffee', '✦ Rasa Autentik', '☕ Nikmati Momen'] as $t)
                <span class="inline-block px-10 text-white font-semibold text-[10px] uppercase tracking-[0.3em] opacity-90">{{ $t }}</span>
            @endforeach
        @endfor
    </div>
</div>

<section class="bg-white py-24 md:py-40 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

        {{-- Image --}}
        <div class="reveal relative">
            <div class="relative overflow-hidden rounded-2xl shadow-2xl transition-transform duration-700 hover:scale-[1.02]">
                <video id="reelsVideo" autoplay loop muted playsinline class="w-full aspect-[4/5] object-cover">
                    <source src="{{ asset('img/calpingreels.mp4') }}" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>

                {{-- Mute/Unmute Toggle --}}
                <button id="muteToggle" class="absolute top-4 right-4 md:top-6 md:right-6 z-20 bg-black/20 backdrop-blur-md text-white p-3 rounded-full hover:bg-black/40 transition-all border border-white/20">
                    <svg id="muteIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                    </svg>
                </button>

                {{-- Live badge --}}
                <div class="absolute bottom-4 left-4 md:bottom-6 md:left-6 flex items-center gap-2 bg-white/90 backdrop-blur-md px-4 py-2 rounded-full">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="font-bold text-stone-900 text-[10px] uppercase tracking-widest">Open Now</span>
                </div>
            </div>
        </div>

        {{-- Text --}}
        <div class="reveal">
            <div class="inline-flex items-center gap-4 mb-8">
                <div class="w-12 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Tentang Kami</span>
            </div>
            <h2 class="text-6xl sm:text-7xl md:text-8xl font-bold text-stone-900 leading-[0.85] mb-8 font-heading uppercase">
                Kopi yang<br><span class="text-stone-300">Bercerita</span>
            </h2>
            <p class="text-stone-600 text-base leading-relaxed mb-8 max-w-md">
                Di Calping, setiap cangkir dibuat dengan perhatian dan cinta. Kami percaya kopi yang baik bukan sekadar minuman — ia adalah momen, percakapan, dan kenangan.
            </p>
            <p class="text-stone-400 text-sm leading-relaxed mb-12 max-w-md">
                Dari biji kopi lokal pilihan terbaik hingga sajian yang memuaskan selera, semua hadir untuk menemani hari-harimu.
            </p>
            <a href="{{ route('ourstory') }}"
               class="group inline-flex items-center gap-4 px-10 py-4 bg-stone-900 text-white rounded-full font-bold text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-stone-800 hover:scale-105">
                Baca Cerita Kami
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>


<section class="bg-stone-50 py-24 md:py-32 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">

        <div class="reveal flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-16 md:mb-20">
            <div>
                <div class="inline-flex items-center gap-4 mb-6">
                    <div class="w-12 h-0.5 bg-stone-900"></div>
                    <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Dari Dapur Kami</span>
                </div>
                <h2 class="text-6xl sm:text-7xl md:text-8xl font-bold text-stone-900 leading-[0.85] font-heading uppercase">
                    Menu<br><span class="text-stone-300">Favorit</span>
                </h2>
            </div>
            <a href="{{ route('customer.scan') }}"
               class="group inline-flex items-center gap-3 text-[10px] uppercase tracking-[0.2em] text-stone-400 hover:text-stone-900 transition-all font-bold border-b border-transparent hover:border-stone-900 pb-1">
                Lihat Semua Menu
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="reveal grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16">
            @foreach($highlights as $i => $item)
            <div class="group">
                <div class="relative bg-white p-4 rounded-3xl shadow-sm border border-stone-100 transition-all duration-500 hover:shadow-2xl hover:-translate-y-4">
                    {{-- Badge --}}
                    <div class="absolute -top-3 right-8 bg-stone-900 text-white text-[8px] font-bold px-4 py-1.5 rounded-full z-20 uppercase tracking-widest">
                        {{ $i == 0 ? 'Monthly Best' : ($i == 1 ? 'Favorite' : 'Top Rated') }}
                    </div>
                    {{-- Image --}}
                    <div class="overflow-hidden mb-6 rounded-2xl bg-stone-100 aspect-[4/5]">
                        <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    {{-- Info --}}
                    <div class="px-2 pb-2">
                        <p class="text-[9px] uppercase tracking-[0.2em] text-stone-400 font-bold mb-2">{{ $item->category->name ?? 'Menu' }}</p>
                        <h3 class="text-2xl font-bold text-stone-900 mb-3 uppercase font-heading tracking-wide">{{ $item->name }}</h3>
                        <p class="text-stone-500 text-xs leading-relaxed line-clamp-2">{{ $item->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="bg-white py-24 md:py-32 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">

        <div class="reveal mb-16 text-center">
            <div class="inline-flex items-center gap-4 mb-6">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Momen Kita</span>
                <div class="w-8 h-0.5 bg-stone-900"></div>
            </div>
            <h2 class="text-6xl sm:text-7xl font-bold text-stone-900 font-heading uppercase tracking-tight">
                #CalpingStory
            </h2>
        </div>

        @php $galleryImages = ['galery1.jpg', 'galery2.jpg', 'galery3.jpg', 'galery4.jpg', 'galery5.jpg', 'galery6.jpg']; @endphp

        <div class="reveal grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($galleryImages as $i => $img)
            <div class="group relative overflow-hidden rounded-2xl transition-all duration-500 hover:scale-[0.98]"
                 style="{{ $i === 0 || $i === 3 ? 'grid-column: span 2; aspect-ratio: 16/9;' : 'aspect-ratio: 1/1;' }}">
                <img src="{{ asset('img/gallery/' . $img) }}" alt="Gallery"
                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="bg-stone-900 py-24 md:py-48 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=40 height=40 viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23FFFFFF\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E')"></div>
    <div class="grain z-10 opacity-5"></div>

    <div class="relative z-10 w-full overflow-hidden mb-16" id="cta-section">
        <div id="cta-scrolling-text" class="whitespace-nowrap flex items-center will-change-transform">
            <!-- Teks diperbanyak agar cukup panjang saat ditarik -->
            <h2 class="text-[18vw] md:text-[12vw] font-bold text-white leading-none font-heading uppercase pr-8 md:pr-12">
                Siap Menikmati
            </h2>
            <h2 class="text-[18vw] md:text-[12vw] font-bold text-stone-500 leading-none font-heading uppercase pr-8 md:pr-12">
                Momen Hari Ini?
            </h2>
            <h2 class="text-[18vw] md:text-[12vw] font-bold text-white leading-none font-heading uppercase pr-8 md:pr-12" aria-hidden="true">
                Siap Menikmati
            </h2>
            <h2 class="text-[18vw] md:text-[12vw] font-bold text-stone-500 leading-none font-heading uppercase pr-8 md:pr-12" aria-hidden="true">
                Momen Hari Ini?
            </h2>
        </div>
    </div>
    
    <div class="relative z-10 text-center px-6">
        <p class="text-stone-400 text-sm md:text-base leading-relaxed mb-16 max-w-lg mx-auto">
            Pilih mejamu, pesan favoritmu, dan biarkan aroma kopi membawa momen terbaikmu.
        </p>
        <a href="{{ route('customer.scan') }}"
           class="group inline-flex items-center gap-4 px-12 py-5 bg-white text-stone-900 rounded-full font-bold text-xs uppercase tracking-[0.2em] transition-all hover:bg-stone-100 hover:scale-105 shadow-xl">
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

// Video Mute Toggle
const video = document.getElementById('reelsVideo');
const muteBtn = document.getElementById('muteToggle');
const muteIcon = document.getElementById('muteIcon');

if (muteBtn && video) {
    muteBtn.addEventListener('click', (e) => {
        e.preventDefault();
        video.muted = !video.muted;
        if (video.muted) {
            muteIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />`;
        } else {
            muteIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />`;
        }
    });
}

// Hero Parallax Mouse Tracking (3D Tilt & Floating)
const hero = document.getElementById('hero-banner');
const handWrapper = document.getElementById('hero-hand-wrapper');
const hand = document.getElementById('hero-hand');

if (hero && hand && handWrapper) {
    // 1. Entrance & Continuous Floating
    gsap.from(hand, {
        y: 100,
        opacity: 0,
        duration: 1.8,
        delay: 0.5,
        ease: "power4.out"
    });

    gsap.to(handWrapper, {
        y: 15,
        duration: 2.5,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
        delay: 2.3 // Start floating after entrance
    });

    // 2. 3D Mouse Tracking (Desktop Only)
    if (window.innerWidth > 1024) {
        hero.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;
            
            // Calculate ratio (-1 to 1) for smoother 3D mapping
            const moveX = (clientX - centerX) / centerX;
            const moveY = (clientY - centerY) / centerY;
            
            gsap.to(hand, {
                x: moveX * 40,
                y: moveY * 40,
                rotationX: -moveY * 12, // Tilt up/down
                rotationY: moveX * 12,  // Tilt left/right
                rotation: moveX * 3,    // Slight 2D rotation
                transformPerspective: 1000,
                duration: 1.5,
                ease: "power3.out"
            });
        });

        // Reset position on mouse leave
        hero.addEventListener('mouseleave', () => {
            gsap.to(hand, {
                x: 0,
                y: 0,
                rotationX: 0,
                rotationY: 0,
                rotation: 0,
                duration: 2,
                ease: "elastic.out(1, 0.5)"
            });
        });
    }
}

// CTA Horizontal Scroll Animation (Scrub)
gsap.set("#cta-scrolling-text", { x: "10%" }); // Posisi awal agak ke kanan
gsap.to("#cta-scrolling-text", {
    x: "-50%", // Bergerak ke kiri sepanjang scroll
    ease: "none",
    scrollTrigger: {
        trigger: "#cta-section",
        start: "top bottom", // Mulai saat elemen masuk dari bawah layar
        end: "bottom top",   // Selesai saat elemen keluar di atas layar
        scrub: 1,            // 1 detik delay untuk efek smooth "mundur" saat scroll dibalik
    }
});
</script>
@endpush

@endsection
