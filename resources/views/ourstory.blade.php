@extends('layouts.guest')

@section('title', 'Cerita Kami - Calping Coffee')

@section('content')
    <!-- Hero Typography -->
    <section class="min-h-screen flex items-center justify-center bg-stone-950 relative overflow-hidden pt-20">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('img/banner-hero.jpg') }}" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-black/60"></div> <!-- Dark overlay for text readability -->
        </div>
        <div class="grain opacity-5 absolute inset-0 pointer-events-none z-10"></div>
        
        <div class="max-w-7xl mx-auto px-6 text-center relative z-20">
            <h1 class="hero-title text-6xl sm:text-8xl md:text-[9vw] font-bold text-white font-heading leading-[0.8] uppercase tracking-tighter" style="opacity: 0; transform: translateY(50px);">
                Bukan Sekadar<br>
                <span class="text-stone-300">Kedai Kopi.</span>
            </h1>
        </div>
    </section>
    
    <!-- Sticky Layout 1: Our Beginning / The Kitchen -->
    <section class="bg-white py-32 md:py-48 relative" id="story-section-1">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
            <div class="flex flex-col md:flex-row gap-16 md:gap-24 relative items-start">
                <!-- Sticky Title -->
                <div class="md:w-1/3 md:sticky md:top-32">
                    <div class="inline-flex items-center gap-4 mb-6">
                        <div class="w-8 h-0.5 bg-stone-900"></div>
                        <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Latar Belakang</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-bold text-stone-900 font-heading uppercase leading-[0.9]">
                        Racikan<br>Jujur
                    </h2>
                </div>
                <!-- Scrolling Content -->
                <div class="md:w-2/3 flex flex-col gap-12 md:gap-16">
                    <p class="text-2xl md:text-3xl text-stone-800 leading-relaxed font-heading uppercase tracking-wide">
                        "Kami adalah ruang tamu bagi warga sekitar. Tempat di mana 'halo' berarti awal dari percakapan panjang."
                    </p>
                    <p class="text-lg md:text-xl text-stone-500 leading-relaxed">
                        Kami tidak punya rahasia. Gula aren asli, susu segar dari peternakan lokal, dan biji kopi yang kami ambil langsung dari petani sahabat. Semuanya transparan, karena kami percaya kejujuran rasa adalah kunci yang membuat orang selalu kembali ke Calping.
                    </p>
                    <div class="overflow-hidden rounded-2xl w-full aspect-[4/3] img-reveal mt-8" style="clip-path: inset(100% 0 0 0);">
                        <img src="{{ asset('img/gallery/galery3.jpg') }}" class="w-full h-full object-cover scale-125">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky Layout 2: The Living Room -->
    <section class="bg-stone-50 py-32 md:py-48 relative" id="story-section-2">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
            <div class="flex flex-col md:flex-row gap-16 md:gap-24 relative items-start">
                <!-- Sticky Title -->
                <div class="md:w-1/3 md:sticky md:top-32">
                    <div class="inline-flex items-center gap-4 mb-6">
                        <div class="w-8 h-0.5 bg-stone-900"></div>
                        <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Komunitas</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-bold text-stone-900 font-heading uppercase leading-[0.9]">
                        Ruang<br>Tamu
                    </h2>
                </div>
                <!-- Scrolling Content -->
                <div class="md:w-2/3 flex flex-col gap-12 md:gap-16">
                    <div class="overflow-hidden rounded-2xl w-full aspect-[4/3] img-reveal mb-8" style="clip-path: inset(100% 0 0 0);">
                        <img src="{{ asset('img/gallery/foto-bersama.jpg') }}" class="w-full h-full object-cover scale-125">
                    </div>
                    <p class="text-2xl md:text-3xl text-stone-800 leading-relaxed font-heading uppercase tracking-wide">
                        "Di sini, tidak ada orang asing, yang ada hanya teman yang belum kenalan."
                    </p>
                    <p class="text-lg md:text-xl text-stone-500 leading-relaxed">
                        Mau kerja remote? Silakan. Mau gosip sore? Boleh banget. Atau cuma mau bengong lihat hujan? Kami sediakan kursinya. Itulah alasan Calping berdiri, menjadi wadah untuk semua cerita hari ini dan memori di masa depan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 md:py-48 bg-stone-900 overflow-hidden relative" id="cta-section">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=40 height=40 viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23FFFFFF\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E')"></div>
        <div class="grain opacity-5"></div>
        
        <div class="relative z-10 w-full overflow-hidden mb-16">
            <div id="cta-scrolling-text" class="whitespace-nowrap flex items-center will-change-transform">
                <h2 class="text-[18vw] md:text-[12vw] font-bold text-white leading-none font-heading uppercase pr-8 md:pr-12">
                    Jadi Bagian dari
                </h2>
                <h2 class="text-[18vw] md:text-[12vw] font-bold text-stone-500 leading-none font-heading uppercase pr-8 md:pr-12">
                    Cerita Kami?
                </h2>
                <h2 class="text-[18vw] md:text-[12vw] font-bold text-white leading-none font-heading uppercase pr-8 md:pr-12" aria-hidden="true">
                    Jadi Bagian dari
                </h2>
                <h2 class="text-[18vw] md:text-[12vw] font-bold text-stone-500 leading-none font-heading uppercase pr-8 md:pr-12" aria-hidden="true">
                    Cerita Kami?
                </h2>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <p class="text-lg text-stone-400 mb-16 leading-relaxed max-w-lg mx-auto">
                Pintu kami selalu terbuka. Datanglah kapan saja, kami seduhkan yang terbaik.
            </p>
            <a href="{{ route('customer.index') }}" class="inline-flex items-center gap-4 px-12 py-5 bg-white text-stone-900 rounded-full font-bold text-xs uppercase tracking-[0.2em] transition-all hover:bg-stone-100 hover:scale-105 shadow-xl">
                <span>Yuk, Mampir Sekarang</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
// Register ScrollTrigger
gsap.registerPlugin(ScrollTrigger);

// 1. Hero Text Reveal
gsap.to(".hero-title", {
    y: 0,
    opacity: 1,
    duration: 1.5,
    ease: "power4.out",
    delay: 0.2
});

// 2. Full Width Image Parallax
gsap.to("#parallax-img", {
    y: "-15%",
    ease: "none",
    scrollTrigger: {
        trigger: "#parallax-img-section",
        start: "top bottom",
        end: "bottom top",
        scrub: true
    }
});

// 3. Image Reveal (Masking dari bawah ke atas)
gsap.utils.toArray('.img-reveal').forEach(container => {
    let img = container.querySelector('img');
    
    let tl = gsap.timeline({
        scrollTrigger: {
            trigger: container,
            start: "top 85%",
            toggleActions: "play reverse play reverse"
        }
    });
    
    // Mask reveal container
    tl.to(container, {
        clipPath: "inset(0% 0% 0% 0%)",
        duration: 1.5,
        ease: "power3.inOut"
    });
    
    // Scale down image inside the mask
    tl.to(img, {
        scale: 1,
        duration: 1.5,
        ease: "power3.inOut"
    }, "<");
});

// CTA Horizontal Scroll Animation (Scrub)
gsap.set("#cta-scrolling-text", { x: "10%" }); 
gsap.to("#cta-scrolling-text", {
    x: "-50%",
    ease: "none",
    scrollTrigger: {
        trigger: "#cta-section",
        start: "top bottom",
        end: "bottom top",
        scrub: 1,
    }
});
</script>
@endpush
@endsection
