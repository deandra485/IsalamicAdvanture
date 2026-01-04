<style>
    /* Custom Animations */
    @keyframes fade-in-up {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    @keyframes scale-in {
        0% { transform: scale(1.1); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-scale-in { animation: scale-in 1.5s ease-out forwards; }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }

    /* Hide scrollbar for cleaner look if needed */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
<div class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-primary-500 selection:text-white">
    
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-900/90 z-10"></div>
            <img src="https://images.unsplash.com/photo-1519904981063-b0cf448d479e?q=80&w=2070" 
                 alt="Mountain Background" 
                 class="w-full h-full object-cover animate-scale-in">
        </div>

        <div class="absolute inset-0 z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20">
            <div class="animate-fade-in-up">
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full mb-8 shadow-xl">
                    <span class="relative flex h-3 w-3 mr-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-white text-sm font-medium tracking-wide">Platform Rental Terpercaya #1</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-8 leading-tight tracking-tight">
                    Jelajahi Petualangan
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-primary-300 via-white to-blue-300">
                        Anda Dimulai Di Sini
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-slate-300 mb-12 max-w-2xl mx-auto leading-relaxed font-light">
                    Sewa peralatan pendakian berkualitas premium dengan harga terjangkau. 
                    Kami memastikan keamanan dan kenyamanan di setiap langkah Anda.
                </p>

                <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                    @auth
                        <a href="{{ route('equipment.index') }}" 
                           class="group relative px-8 py-4 bg-primary-600 text-white rounded-2xl font-bold text-lg overflow-hidden transition-all duration-300 hover:shadow-[0_0_40px_-10px_rgba(var(--primary-rgb),0.5)] hover:-translate-y-1 w-full sm:w-auto">
                            <span class="relative z-10 flex items-center justify-center">
                                Mulai Sewa Peralatan
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="group relative px-8 py-4 bg-white text-slate-900 rounded-2xl font-bold text-lg overflow-hidden transition-all duration-300 hover:shadow-[0_0_40px_-10px_rgba(255,255,255,0.5)] hover:-translate-y-1 w-full sm:w-auto">
                            <span class="relative z-10 flex items-center justify-center">
                                Daftar Sekarang
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('login') }}" 
                           class="px-8 py-4 bg-white/5 backdrop-blur-sm text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/10 hover:border-white/40 transition-all w-full sm:w-auto">
                            Masuk Akun
                        </a>
                    @endauth

                    <a href="{{ route('mountains.index') }}" 
                       class="group px-8 py-4 bg-transparent text-slate-200 border border-slate-500/50 rounded-2xl font-semibold text-lg hover:bg-slate-800/50 hover:text-white transition-all w-full sm:w-auto flex items-center justify-center">
                       <span>Jelajahi Gunung</span>
                    </a>
                </div>

                <div class="mt-20 flex flex-wrap justify-center gap-6 sm:gap-12 text-slate-300/80 border-t border-white/10 pt-8">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/5 rounded-lg">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="font-medium text-sm">Peralatan Terawat</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/5 rounded-lg">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="font-medium text-sm">Harga Kompetitif</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/5 rounded-lg">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="font-medium text-sm">Proses Kilat</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
            <div class="w-8 h-12 border-2 border-white/30 rounded-full flex justify-center pt-2">
                <div class="w-1 h-2 bg-white rounded-full animate-ping"></div>
            </div>
        </div>
    </section>

    <section class="relative bg-slate-50 overflow-hidden pt-24 pb-16 lg:pt-32 lg:pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <div class="max-w-2xl">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-blue-600 text-sm font-semibold mb-6">
                    New Adventure 2026
                </span>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                    Jelajahi Keindahan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Alam Indonesia</span>
                </h1>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                    Temukan destinasi tersembunyi yang belum pernah Anda bayangkan. Dari pegunungan berkabut hingga pantai tropis, kami siapkan perjalanan tak terlupakan.
                </p>
                
                <div class="flex flex-wrap gap-4 mb-10">
                    <a href="#" class="px-8 py-4 rounded-full bg-blue-600 text-white font-bold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                        Mulai Petualangan
                    </a>
                    <a href="#" class="px-8 py-4 rounded-full bg-white text-slate-700 border border-slate-200 font-bold text-lg hover:bg-slate-50 transition">
                        Lihat Galeri
                    </a>
                </div>

                <div class="flex items-center gap-8 text-slate-900 border-t border-slate-200 pt-8">
                    <div>
                        <p class="text-3xl font-bold">500+</p>
                        <p class="text-sm text-slate-500">Destinasi</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">10k+</p>
                        <p class="text-sm text-slate-500">Pelanggan</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">4.9</p>
                        <p class="text-sm text-slate-500">Rating</p>
                    </div>
                </div>
            </div>

            <div class="relative lg:ml-10">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             alt="Danau Gunung" 
                             class="w-full h-64 object-cover rounded-2xl shadow-xl hover:scale-[1.02] transition duration-500">
                        
                        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             alt="Traveler" 
                             class="w-full h-40 object-cover rounded-2xl shadow-xl hover:scale-[1.02] transition duration-500">
                    </div>
                    
                    <div class="space-y-4 pt-12">
                        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             alt="Pemandangan Laut" 
                             class="w-full h-40 object-cover rounded-2xl shadow-xl hover:scale-[1.02] transition duration-500">
                             
                        <img src="https://images.unsplash.com/photo-1530789253388-582c481c54b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             alt="Hutan Tropis" 
                             class="w-full h-64 object-cover rounded-2xl shadow-xl hover:scale-[1.02] transition duration-500">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

   <section class="relative bg-slate-900 overflow-hidden py-24 lg:py-32">

    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="topo" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <path d="M0 0 Q 25 25 50 0 T 100 0" fill="none" stroke="white" stroke-width="2"/>
                    <path d="M0 50 Q 25 75 50 50 T 100 50" fill="none" stroke="white" stroke-width="2"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#topo)" />
        </svg>
    </div>

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-500/20 rounded-full blur-[100px] -z-10"></div>

    <div class="container mx-auto px-6 relative z-10 text-center">
        
        <div class="relative inline-block mb-10 group">
            <div class="absolute inset-0 rounded-full border border-emerald-500/30 scale-110 group-hover:scale-125 transition duration-700"></div>
            <div class="absolute inset-0 rounded-full border border-emerald-500/10 scale-125 group-hover:scale-150 transition duration-1000 delay-100"></div>
            
            <div class="relative w-40 h-40 md:w-48 md:h-48 rounded-full p-2 bg-gradient-to-b from-slate-700 to-slate-900 shadow-2xl">
                <img src="https://images.unsplash.com/photo-1544377395-5f50d18d8d3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                     alt="Sir Edmund Hillary" 
                     class="w-full h-full rounded-full object-cover border-4 border-slate-800 grayscale group-hover:grayscale-0 transition duration-500">
                
                <div class="absolute bottom-0 right-0 bg-emerald-600 text-white p-3 rounded-full border-4 border-slate-900 shadow-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 13.1216 16 12.017 16H9.01703C7.91246 16 7.01703 16.8954 7.01703 18V21H14.017ZM16.017 21H20.017C21.1216 21 22.017 20.1046 22.017 19V11.232C22.017 10.1581 21.2821 9.21556 20.2356 8.97745C16.8532 8.20786 14.5976 5.86016 14.5976 5.86016C14.5976 5.86016 14.5976 4.90425 14.5976 3C14.5976 1.89543 13.7022 1 12.5976 1H4.01703C2.91246 1 2.01703 1.89543 2.01703 3V19C2.01703 20.1046 2.91246 21 4.01703 21H5.01703V18C5.01703 15.7909 6.80789 14 9.01703 14H12.017C14.2262 14 16.017 15.7909 16.017 18V21Z" /></svg>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-6 tracking-wide">
                "Bukan gunung yang kita taklukkan, melainkan <span class="text-emerald-400">diri kita sendiri</span>."
            </h2>
            
            <div class="flex flex-col items-center justify-center gap-1">
                <p class="text-xl text-white font-semibold">Sir Edmund Hillary</p>
                <p class="text-sm text-slate-400 uppercase tracking-widest">Penakluk Everest Pertama</p>
            </div>

            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-emerald-500 to-transparent mx-auto my-10"></div>

            <p class="text-slate-400 text-lg mb-10 italic">
                Rasa sakit hari ini adalah kekuatanmu di hari esok. Jangan berhenti melangkah.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button class="px-8 py-3 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-lg shadow-emerald-900/50">
                    Gabung Open Trip 2026
                </button>
                <button class="px-8 py-3 rounded-full bg-transparent border border-slate-600 hover:border-emerald-400 text-slate-300 hover:text-emerald-400 font-semibold transition">
                    Lihat Galeri Perjalanan
                </button>
            </div>
        </div>

    </div>
</section>

    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6">Mengapa IslamicAdvanture?</h2>
                <p class="text-lg text-slate-600">Kami memberikan standar baru dalam penyewaan alat outdoor.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-primary-900/5 transition-all duration-300 hover:-translate-y-2 border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-primary-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    
                    <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center mb-6 text-primary-600 relative z-10">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 relative z-10">Quality Check Ketat</h3>
                    <p class="text-slate-500 leading-relaxed relative z-10">Setiap alat melewati proses inspeksi 3 tahap sebelum dan sesudah penyewaan untuk keamanan maksimal.</p>
                </div>

                <div class="group bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-green-900/5 transition-all duration-300 hover:-translate-y-2 border border-slate-100 relative overflow-hidden">
                     <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-green-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>

                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-6 text-green-600 relative z-10">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 relative z-10">Harga Transparan</h3>
                    <p class="text-slate-500 leading-relaxed relative z-10">Tidak ada biaya tersembunyi. Harga yang Anda lihat adalah harga yang Anda bayar. Diskon untuk durasi panjang.</p>
                </div>

                <div class="group bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-blue-900/5 transition-all duration-300 hover:-translate-y-2 border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 text-blue-600 relative z-10">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 relative z-10">Support Petualangan</h3>
                    <p class="text-slate-500 leading-relaxed relative z-10">Konsultasi gratis mengenai jalur pendakian dan penggunaan alat bagi pemula.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-32 overflow-hidden mx-4 mb-4 rounded-[3rem]">
        <div class="absolute inset-0 z-0">
             <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070" 
                 alt="Background" 
                 class="w-full h-full object-cover">
             <div class="absolute inset-0 bg-slate-900/80 mix-blend-multiply"></div>
             <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-slate-900/50"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-8 tracking-tight leading-tight">
                Gunung Memanggil,<br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-blue-300">Siap Menjawab?</span>
            </h2>
            <p class="text-xl text-slate-300 mb-12 max-w-2xl mx-auto font-light">
                Jangan biarkan perlengkapan menghalangi mimpi Anda. Sewa sekarang dan rasakan kebebasan di alam liar.
            </p>
            
            @auth
                <a href="{{ route('equipment.index') }}" 
                   class="inline-flex items-center px-10 py-5 bg-white text-slate-900 rounded-full font-bold text-lg hover:bg-slate-100 transition-all shadow-[0_0_40px_-10px_rgba(255,255,255,0.4)] transform hover:scale-105">
                    Mulai Petualangan
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            @else
                <div class="flex flex-col sm:flex-row gap-5 justify-center">
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center justify-center px-10 py-5 bg-primary-600 text-white rounded-full font-bold text-lg hover:bg-primary-500 transition-all shadow-xl shadow-primary-900/50 transform hover:scale-105">
                        Buat Akun Gratis
                    </a>
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/30 rounded-full font-bold text-lg hover:bg-white/20 transition-all">
                        Masuk Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </section>
</div>