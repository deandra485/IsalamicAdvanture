<div class="min-h-screen bg-slate-50 font-sans text-slate-900">
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-emerald-100/50 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-blue-100/50 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                Jelajahi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Gunung Indonesia</span>
            </h1>
            <p class="text-lg text-slate-600 leading-relaxed">
                Temukan tantangan baru, nikmati keindahan alam, dan rasakan pengalaman pendakian tak terlupakan.
            </p>
        </div>

        <div class="sticky top-4 z-30 mb-12">
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl shadow-slate-200/50 border border-white/50 p-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    
                    <div class="md:col-span-4 relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               wire:model.live.debounce.500ms="search"
                               class="block w-full pl-10 pr-3 py-3 border-0 bg-slate-100/50 rounded-xl text-slate-900 placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all duration-200 sm:text-sm font-medium"
                               placeholder="Cari nama gunung...">
                    </div>

                    <div class="md:col-span-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="relative">
                            <select wire:model.live="lokasi" 
                                    class="block w-full py-3 pl-3 pr-10 border-0 bg-slate-100/50 rounded-xl text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-sm cursor-pointer">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $loc)
                                <option value="{{ $loc }}">{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="relative">
                            <select wire:model.live="tingkat_kesulitan" 
                                    class="block w-full py-3 pl-3 pr-10 border-0 bg-slate-100/50 rounded-xl text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-sm cursor-pointer">
                                <option value="">Semua Level</option>
                                <option value="mudah">Mudah</option>
                                <option value="sedang">Sedang</option>
                                <option value="sulit">Sulit</option>
                                <option value="sangat sulit">Ekstrem</option>
                            </select>
                        </div>

                        <div class="relative">
                            <select wire:model.live="sortBy" 
                                    class="block w-full py-3 pl-3 pr-10 border-0 bg-slate-100/50 rounded-xl text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-sm cursor-pointer">
                                <option value="created_at">Terbaru</option>
                                <option value="nama_gunung">Nama (A-Z)</option>
                                <option value="ketinggian">Ketinggian</option>
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2 text-right flex justify-end">
                        @if($search || $lokasi || $tingkat_kesulitan)
                        <button wire:click="$set('search', ''); $set('lokasi', ''); $set('tingkat_kesulitan', '');" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-red-600 bg-red-50 hover:bg-red-100 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($mountains as $mountain)
            <a href="{{ route('mountains.show', $mountain) }}" 
               class="group relative flex flex-col bg-white rounded-3xl shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-slate-100"
               wire:key="mountain-{{ $mountain->id }}">
                
                <div class="relative aspect-[4/3] overflow-hidden">
                    @if($mountain->image_url)
                        <img src="{{ Storage::url($mountain->image_url) }}" 
                             alt="{{ $mountain->nama_gunung }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    @else
                        <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                    
                    <div class="absolute top-4 right-4">
                        @php
                            $diffColor = match($mountain->tingkat_kesulitan) {
                                'mudah' => 'bg-emerald-500',
                                'sedang' => 'bg-yellow-500',
                                'sulit' => 'bg-orange-500',
                                'sangat sulit' => 'bg-red-600',
                                default => 'bg-slate-500',
                            };
                        @endphp
                        <span class="{{ $diffColor }} text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm bg-opacity-90 tracking-wide uppercase">
                            {{ ucfirst($mountain->tingkat_kesulitan) }}
                        </span>
                    </div>

                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-slate-100">{{ $mountain->lokasi }}</span>
                        </div>
                        <h3 class="text-2xl font-bold leading-tight group-hover:text-emerald-300 transition-colors">
                            {{ $mountain->nama_gunung }}
                        </h3>
                    </div>
                </div>
                
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-4 mb-4 text-sm text-slate-600">
                            <div class="flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span class="font-semibold text-slate-900 mr-1">{{ number_format($mountain->ketinggian) }}</span> mdpl
                            </div>
                            @if($mountain->hikingRoutes->count() > 0)
                            <div class="flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-4"></span>
                                {{ $mountain->hikingRoutes->count() }} Jalur
                            </div>
                            @endif
                        </div>

                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-4">
                            {{ $mountain->deskripsi ?? 'Belum ada deskripsi mendetail untuk gunung ini.' }}
                        </p>
                    </div>

                    <div class="pt-4 mt-2 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                            {{ $mountain->packages->count() }} Paket Tersedia
                        </span>
                        <span class="inline-flex items-center text-emerald-600 font-semibold text-sm group-hover:translate-x-1 transition-transform">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-slate-100 p-6 rounded-full mb-4">
                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Gunung tidak ditemukan</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-6">Kami tidak dapat menemukan gunung yang cocok dengan pencarian Anda. Coba kata kunci lain atau reset filter.</p>
                <button wire:click="$set('search', ''); $set('lokasi', ''); $set('tingkat_kesulitan', '');" 
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium shadow-lg shadow-emerald-600/30 transition-all active:scale-95">
                    Reset Filter
                </button>
            </div>
            @endforelse
        </div>

        @if($mountains->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
                {{ $mountains->links() }}
            </div>
        </div>
        @endif
    </div>
</div>