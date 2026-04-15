@extends('layouts.guest')

@section('title', 'Lokasi - CalpingPos')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 bg-coffee-200 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-coffee-900 font-heading mb-4">Mampir Ke CalpingCoffee.</h1>
        <p class="text-lg text-coffee-700 max-w-2xl mx-auto px-4">
            Pintu kami selalu terbuka lebar. Datanglah untuk kopinya, tinggallah untuk suasananya.
        </p>
    </section>

    <!-- Main Location Content -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Map Area -->
                <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-cream-100 h-[300px] md:h-[500px] relative group">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.607163534185!2d106.63078670000002!3d-6.183298799999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f92a97802429%3A0x6922a2312902d391!2sJl.%20Kalipasir%20Indah%20No.145%2C%20Sukasari%2C%20Kec.%20Tangerang%2C%20Kota%20Tangerang%2C%20Banten%2015118!5e0!3m2!1sid!2sid!4v1767733048794!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        class="grayscale group-hover:grayscale-0 transition-all duration-700">
                    </iframe>
                    <!-- Overlay Info -->
                    <div class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-coffee-100 md:w-80">
                        <h3 class="font-bold text-coffee-900 text-lg mb-1 font-heading">CalpingPos HQ</h3>
                        <p class="text-coffee-600 text-sm">Tangerang, Banten</p>
                        <a href="https://maps.app.goo.gl/35bY3n7Y7r8v3v1v6" target="_blank" class="mt-4 inline-flex items-center text-sm font-bold text-coffee-900 hover:text-coffee-600">
                            Buka di Google Maps
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Details Area -->
                <div class="space-y-8">
                    <!-- Address Card -->
                    <div class="bg-cream-50 p-8 rounded-3xl border border-coffee-100">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-coffee-900 text-white flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl text-coffee-900 mb-2 font-heading">Alamat</h3>
                                <p class="text-coffee-700 leading-relaxed">
                                    Jl. Kalipasir Indah No.145<br>
                                    Sukasari, Kec. Tangerang<br>
                                    Kota Tangerang, Banten 15118
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Hours Card -->
                    <div class="bg-cream-50 p-8 rounded-3xl border border-coffee-100">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-coffee-900 text-white flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl text-coffee-900 mb-2 font-heading">Jam Operasional</h3>
                                <div class="space-y-2 text-coffee-700">
                                    <div class="flex justify-between items-start w-full border-b border-coffee-200 pb-1 gap-4">
                                        <span class="leading-tight">Senin - Jumat, Minggu</span>
                                        <span class="font-bold whitespace-nowrap text-coffee-900">15:00 - 00:00</span>
                                    </div>
                                    <div class="flex justify-between items-start w-full border-b border-coffee-200 pb-1 gap-4">
                                        <span class="leading-tight">Sabtu</span>
                                        <span class="font-bold whitespace-nowrap text-coffee-900">15:00 - 01:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div>
                        <h3 class="font-bold text-xl text-coffee-900 mb-6 font-heading">Fasilitas Calping</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div class="flex items-center gap-2 text-coffee-700 bg-white p-3 rounded-xl border border-coffee-50 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                                <span class="text-sm font-medium">WiFi Kenceng</span>
                            </div>
                            <div class="flex items-center gap-2 text-coffee-700 bg-white p-3 rounded-xl border border-coffee-50 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                <span class="text-sm font-medium">Banyak Colokan</span>
                            </div>
                            <div class="flex items-center gap-2 text-coffee-700 bg-white p-3 rounded-xl border border-coffee-50 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span class="text-sm font-medium">Area Indoor/Outdoor</span>
                            </div>
                            <div class="flex items-center gap-2 text-coffee-700 bg-white p-3 rounded-xl border border-coffee-50 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-medium">Pet Friendly</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ / Contact -->
    <section class="py-20 bg-cream-50 border-t border-coffee-100">
        <div class="max-w-3xl mx-auto px-4 text-center">
             <h2 class="text-3xl font-bold text-coffee-900 font-heading mb-6">Mau Tanya-Tanya?</h2>
             <p class="text-coffee-700 mb-8">
                 Jangan sungkan. Telepon, WhatsApp, atau DM Instagram. Tim kami selalu membalas.
             </p>
             <div class="flex flex-wrap justify-center gap-4">
                 <a href="https://wa.me/628561163681" class="inline-flex items-center gap-2 px-8 py-3 bg-green-600 text-white rounded-full font-bold shadow-lg hover:bg-green-700 transition">
                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.506-.669-.516-.173-.009-.371-.009-.57-.009-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                     Chat WhatsApp
                 </a>
                 <a href="https://www.instagram.com/calpingkopi/" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600 text-white rounded-full font-bold shadow-lg hover:opacity-90 transition">
                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                     Instagram
                 </a>
             </div>
        </div>
    </section>
@endsection
