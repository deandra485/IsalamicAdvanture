<div class="container mx-auto px-4 py-12 max-w-7xl">
    <div class="text-center mb-12">
        <span class="text-emerald-600 font-semibold tracking-wider uppercase text-sm mb-2 block">Petualangan Menanti</span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
            Jelajahi Paket Pendakian
        </h1>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">
            Temukan pengalaman mendaki terbaik dengan fasilitas lengkap dan pemandu profesional di gunung-gunung terindah.
        </p>
    </div>

    <div class="space-y-4 mb-8">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-emerald-800 font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-400 hover:text-red-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
            <div class="md:col-span-5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari paket atau gunung..."
                        class="pl-10 w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 transition duration-200 ease-in-out hover:bg-white"
                    >
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Destinasi</label>
                <div class="relative">
                    <select 
                        wire:model.live="mountainFilter"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 appearance-none hover:bg-white transition"
                    >
                        <option value="">Semua Gunung</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->mountain->id }}">{{ $package->mountain->nama_gunung }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Urutkan</label>
                <div class="relative">
                    <select 
                        wire:model.live="sortBy"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block p-3 appearance-none hover:bg-white transition"
                    >
                        <option value="nama_paket">Nama (A-Z)</option>
                        <option value="harga_paket">Harga Termurah</option>
                        <option value="durasi_hari">Durasi Pendek</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="md:col-span-1 flex justify-center pb-1">
                @if($search || $mountainFilter)
                    <button 
                        wire:click="clearFilters"
                        class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50"
                        title="Reset Filter"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($packages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($packages as $package)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full">
                    <div class="relative h-64 overflow-hidden">
                        @if($package->mountain->image_url)
                            <img 
                                src="{{ asset('storage/' . $package->mountain->image_url) }}" 
                                alt="{{ $package->mountain->nama_paket }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out"
                            >
                        @else
                             <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-cyan-600 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-700">
                                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M5 18v3M19 18v3M5 10l5-5 4 4 4-6v12H5V10z"></path></svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 backdrop-blur-sm text-gray-800 shadow-sm">
                                <svg class="w-3 h-3 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $package->mountain->nama_paket }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4">
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-900/80 backdrop-blur-sm text-white shadow-sm">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $package->durasi_hari }} Hari
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-1">
                            {{ $package->nama_paket }}
                        </h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed flex-1">
                            {{ $package->deskripsi }}
                        </p>

                        <div class="border-t border-gray-100 my-4"></div>

                        <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                            <div class="flex items-center tooltip" title="Peralatan Termasuk">
                                <div class="bg-emerald-50 p-2 rounded-lg text-emerald-600 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                </div>
                                <span class="font-medium">{{ $package->equipment->count() }} Peralatan</span>
                            </div>
                             <div class="flex items-center">
                                <div class="bg-blue-50 p-2 rounded-lg text-blue-600 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <span class="font-medium">Guide</span>
                            </div>
                        </div>

                        <div class="flex items-end justify-between gap-4 mt-auto">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Mulai dari</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    <span class="text-sm font-normal text-gray-500 align-top">Rp</span>
                                    {{ number_format($package->harga_paket, 0, ',', '.') }}
                                </p>
                            </div>
                            
                           <div class="flex gap-2">
                                {{-- Tombol Icon Mata (Tetap ke Show) --}}
                                <a href="{{ route('packages.show', $package->id) }}" class="p-3 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors border border-transparent hover:border-emerald-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>

                                {{-- Tombol Utama (PERBAIKAN: Menggunakan tag <a> dan href) --}}
                                <a href="{{ route('packages.show', $package->id) }}" 
                                class="px-4 py-3 bg-gray-900 text-white rounded-xl hover:bg-emerald-600 transition-colors shadow-lg hover:shadow-emerald-500/30 flex items-center font-medium text-sm cursor-pointer">
                                    
                                    {{-- Icon Panah Kanan (Lebih cocok untuk 'Lihat Detail') --}}
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $packages->links() }} 
        </div>

    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Paket tidak ditemukan</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Kami tidak dapat menemukan paket pendakian yang sesuai dengan kriteria pencarian Anda.</p>
            
            @if($search || $mountainFilter)
                <button 
                    wire:click="clearFilters"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-emerald-700 bg-emerald-100 hover:bg-emerald-200 transition-colors"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reset Filter
                </button>
            @endif
        </div>
    @endif
</div>