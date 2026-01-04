<div class="min-h-screen bg-slate-50 font-sans text-slate-900 pb-20">
    
    <section class="relative h-[60vh] min-h-[500px] group">
        <div class="absolute inset-0 overflow-hidden">
            @if($mountain->image_url)
                <img src="{{ Storage::url($mountain->image_url) }}" 
                     alt="{{ $mountain->nama_gunung }}"
                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-[2s] ease-out">
            @else
                <div class="w-full h-full bg-gradient-to-br from-emerald-800 to-slate-900"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/80"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
        </div>

        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 w-full">
                <nav class="mb-6 hidden sm:block">
                    <ol class="flex items-center space-x-2 text-sm text-slate-300">
                        <li><a href="/" class="hover:text-emerald-400 transition">Home</a></li>
                        <li class="text-slate-500">/</li>
                        <li><a href="{{ route('mountains.index') }}" class="hover:text-emerald-400 transition">Gunung</a></li>
                        <li class="text-slate-500">/</li>
                        <li class="text-white font-medium">{{ $mountain->nama_gunung }}</li>
                    </ol>
                </nav>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-4">
                        @php
                            $badgeColor = match($mountain->tingkat_kesulitan) {
                                'mudah' => 'bg-emerald-500',
                                'sedang' => 'bg-yellow-500',
                                'sulit' => 'bg-orange-500',
                                'sangat sulit' => 'bg-red-600',
                                default => 'bg-slate-500',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase text-white backdrop-blur-md bg-opacity-90 shadow-lg {{ $badgeColor }}">
                            {{ ucfirst($mountain->tingkat_kesulitan) }}
                        </span>

                        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">
                            {{ $mountain->nama_gunung }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-6 text-slate-200 text-sm md:text-base font-medium">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $mountain->lokasi }}
                            </div>
                            <div class="w-1 h-1 rounded-full bg-slate-500"></div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                {{ number_format($mountain->ketinggian) }} mdpl
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                @if($mountain->deskripsi)
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-slate-100">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                        <span class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mr-3 text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </span>
                        Tentang Gunung
                    </h2>
                    <div class="prose prose-slate prose-lg text-slate-600 leading-relaxed max-w-none">
                        <p>{{ $mountain->deskripsi }}</p>
                    </div>
                </div>
                @endif

                @if($mountain->hikingRoutes->count() > 0)
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 flex items-center">
                            <span class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mr-3 text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            </span>
                            Jalur Pendakian
                        </h2>
                        <span class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $mountain->hikingRoutes->count() }} Jalur
                        </span>
                    </div>

                    <div class="space-y-4">
                        @foreach($mountain->hikingRoutes as $route)
                        <div class="group relative bg-slate-50 hover:bg-white rounded-2xl p-5 border border-slate-100 hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
                            <div class="absolute top-5 right-5">
                                @if($route->is_available)
                                    <span class="flex items-center gap-1.5 px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Buka
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 px-2.5 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Tutup
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-emerald-700 transition-colors">
                                {{ $route->nama_jalur }}
                            </h3>
                            
                            <div class="flex flex-wrap gap-4 my-3 text-sm text-slate-600">
                                <div class="flex items-center gap-1.5 bg-white px-2 py-1 rounded-md border border-slate-100 shadow-sm">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $route->estimasi_waktu_hari }} Hari
                                </div>
                                @if($route->jarak_km)
                                <div class="flex items-center gap-1.5 bg-white px-2 py-1 rounded-md border border-slate-100 shadow-sm">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    {{ $route->jarak_km }} km
                                </div>
                                @endif
                                <div class="flex items-center gap-1.5 bg-white px-2 py-1 rounded-md border border-slate-100 shadow-sm">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    {{ ucfirst($route->tingkat_kesulitan) }}
                                </div>
                            </div>

                            @if($route->deskripsi_jalur)
                                <p class="text-sm text-slate-500 leading-relaxed">{{ $route->deskripsi_jalur }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($mountain->reviews->count() > 0)
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-slate-100">
                    <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center">
                        <span class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center mr-3 text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </span>
                        Ulasan Pendaki
                        <span class="ml-2 text-sm font-normal text-slate-500">({{ $mountain->reviews->count() }} ulasan)</span>
                    </h2>
                    
                    <div class="grid gap-6">
                        @foreach($mountain->reviews as $review)
                        <div class="pb-6 border-b border-slate-100 last:border-0 last:pb-0">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-slate-600 font-bold shadow-sm">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="font-bold text-slate-900">{{ $review->user->name }}</h4>
                                        <div class="flex items-center text-xs text-slate-500">
                                            <span>{{ $review->created_at->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center bg-yellow-50 px-2 py-1 rounded-lg border border-yellow-100">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-bold text-yellow-700">{{ $review->rating }}.0</span>
                                </div>
                            </div>
                            @if($review->komentar)
                            <p class="mt-3 text-slate-600 bg-slate-50 p-3 rounded-xl rounded-tl-none italic text-sm">
                                "{{ $review->komentar }}"
                            </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    
                    @if($mountain->packages->count() > 0)
                    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                        <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                            <h3 class="font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Paket Trip
                            </h3>
                            <span class="text-xs font-medium bg-emerald-600 text-white px-2 py-0.5 rounded">Terlaris</span>
                        </div>
                        <div class="p-4 space-y-3">
                            @foreach($mountain->packages->take(3) as $package)
                            <a href="{{ route('packages.show', $package) }}" 
                               class="group block p-3 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-emerald-300 hover:shadow-md transition-all">
                                <h4 class="font-bold text-slate-800 text-sm mb-1 group-hover:text-emerald-600 transition-colors">
                                    {{ $package->nama_paket }}
                                </h4>
                                <div class="flex items-end justify-between">
                                    <span class="text-xs text-slate-500">{{ $package->durasi_hari }} Hari</span>
                                    <span class="text-emerald-600 font-bold text-sm">
                                        Rp {{ number_format($package->harga_paket, 0, ',', '.') }}
                                    </span>
                                </div>
                            </a>
                            @endforeach
                            
                            @if($mountain->packages->count() > 3)
                            <a href="{{ route('packages.index') }}?mountain={{ $mountain->id }}" 
                               class="block w-full py-2 text-center text-sm font-medium text-slate-600 hover:text-emerald-600 transition">
                                Lihat {{ $mountain->packages->count() - 3 }} paket lainnya →
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 shadow-xl shadow-emerald-500/20 text-white p-6">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/10 rounded-full blur-xl"></div>
                        
                        <h3 class="relative text-lg font-bold mb-2">Belum Punya Alat?</h3>
                        <p class="relative text-emerald-100 text-sm mb-5 leading-relaxed">
                            Jangan khawatir! Kami menyewakan peralatan mendaki berkualitas dan steril.
                        </p>
                        <a href="{{ route('equipment.index') }}" 
                           class="relative block w-full py-3 bg-white text-emerald-700 rounded-xl font-bold text-center hover:bg-emerald-50 hover:shadow-lg transition-all active:scale-95">
                            Sewa Sekarang
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Bagikan ke Teman</h3>
                        <div class="flex gap-2">
                            <button class="flex-1 py-2.5 rounded-lg bg-slate-50 text-slate-600 hover:bg-[#1877F2] hover:text-white transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </button>
                            <button class="flex-1 py-2.5 rounded-lg bg-slate-50 text-slate-600 hover:bg-[#1DA1F2] hover:text-white transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </button>
                            <button class="flex-1 py-2.5 rounded-lg bg-slate-50 text-slate-600 hover:bg-[#25D366] hover:text-white transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>