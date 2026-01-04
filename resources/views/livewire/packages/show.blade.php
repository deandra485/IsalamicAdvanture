<div class="container mx-auto px-4 py-8 max-w-7xl">
    <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-gray-500 hover:text-emerald-600 font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('packages.index') }}" class="ml-1 text-gray-500 hover:text-emerald-600 font-medium transition-colors md:ml-2">Paket</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-gray-900 font-semibold md:ml-2">{{ $package->nama_paket }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="fixed top-4 right-4 z-50 w-full max-w-sm space-y-2 pointer-events-none">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="pointer-events-auto bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded shadow-lg flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-emerald-800 text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-8">
            
            <div class="relative rounded-3xl overflow-hidden shadow-xl bg-gray-100 group h-[400px] md:h-[500px]">
                @if($package->mountain->image_url)
                    <img 
                        src="{{ asset('storage/' . $package->mountain->image_url) }}" 
                        alt="{{ $package->mountain->nama_gunung }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                    >
                @else
                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-cyan-700 flex items-center justify-center">
                         <svg class="w-24 h-24 text-white opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 21h18M5 18v3M19 18v3M5 10l5-5 4 4 4-6v12H5V10z"></path></svg>
                    </div>
                @endif
                
                <div class="absolute top-6 left-6 flex gap-2">
                    <span class="bg-white/90 backdrop-blur-md text-emerald-800 text-sm font-bold px-4 py-1.5 rounded-full shadow-sm flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $package->mountain->nama_gunung }}
                    </span>
                </div>
                
                <div class="absolute bottom-6 right-6">
                     <span class="bg-gray-900/80 backdrop-blur-md text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $package->durasi_hari }} Hari Petualangan
                    </span>
                </div>
            </div>

            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $package->nama_paket }}</h1>
                
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-emerald-50 rounded-2xl p-4 text-center border border-emerald-100">
                        <div class="text-emerald-600 mb-1 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="font-bold text-gray-900 text-lg">{{ $package->mountain->ketinggian }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide font-semibold">MDPL</div>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-4 text-center border border-blue-100">
                        <div class="text-blue-600 mb-1 flex justify-center">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="font-bold text-gray-900 text-lg">{{ $package->equipment->count() }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Item Alat</div>
                    </div>
                    <div class="bg-purple-50 rounded-2xl p-4 text-center border border-purple-100">
                         <div class="text-purple-600 mb-1 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="font-bold text-gray-900 text-lg">Privat</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Trip Type</div>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-3">Tentang Paket</h3>
                <div class="prose prose-emerald max-w-none text-gray-600 leading-relaxed bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    {{ $package->deskripsi }}
                </div>
            </div>

            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="bg-emerald-100 text-emerald-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </span>
                    Fasilitas & Peralatan
                </h3>
                
                @if($package->equipment->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($package->equipment as $equipment)
                            <div class="flex items-start p-4 bg-white border border-gray-200 rounded-xl hover:shadow-md hover:border-emerald-300 transition-all duration-300 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mr-4 group-hover:bg-emerald-50 transition-colors">
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $equipment->name }}</h4>
                                        <span class="text-xs font-semibold px-2 py-1 rounded bg-gray-100 text-gray-600">x1</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">{{ $equipment->description }}</p>
                                    <div class="mt-2 text-xs flex items-center">
                                        <span class="w-2 h-2 rounded-full {{ $equipment->stock > 5 ? 'bg-green-500' : 'bg-orange-500' }} mr-2"></span>
                                        <span class="text-gray-400">Tersedia</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-gray-50 rounded-xl text-gray-500 text-center italic">
                        Tidak ada detail peralatan khusus untuk paket ini.
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-6">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 p-6 border-b border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Mulai petualangan dari</p>
                        <div class="flex items-baseline">
                            <span class="text-sm font-semibold text-gray-500 align-top mr-1">Rp</span>
                            <span class="text-3xl font-extrabold text-emerald-600">{{ number_format($package->harga_paket, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-400 ml-1">/ pax</span>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Jumlah Peserta</label>
                            <div class="flex items-center justify-between bg-gray-50 rounded-2xl p-2 border border-gray-200">
                                <button 
                                    wire:click="decrementQuantity"
                                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-white shadow-sm text-gray-600 hover:text-red-500 hover:bg-red-50 transition-colors {{ $quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $quantity <= 1 ? 'disabled' : '' }}
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                
                                <span class="text-xl font-bold text-gray-900 w-12 text-center">{{ $quantity }}</span>
                                
                                <button 
                                    wire:click="incrementQuantity"
                                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-white shadow-sm text-gray-600 hover:text-emerald-500 hover:bg-emerald-50 transition-colors"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center py-4 border-t border-dashed border-gray-200">
                            <span class="text-gray-600 font-medium">Total Pembayaran</span>
                            <span class="text-xl font-bold text-gray-900">
                                Rp {{ number_format($package->harga_paket * $quantity, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="space-y-3">
                            <button 
                                wire:click="addToCart"
                                class="w-full py-4 px-6 bg-gray-900 text-white rounded-xl hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 font-bold text-lg flex justify-center items-center"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Tambah ke Keranjang
                            </button>
                            
                            <a 
                                href="{{ route('packages.index') }}"
                                class="w-full py-3 px-6 bg-white text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors font-medium text-center block"
                            >
                                Cari Paket Lain
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-blue-50/50 rounded-2xl p-5 border border-blue-100">
                    <h4 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Kenapa Memilih Kami?</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start text-sm text-gray-600">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            Pemandu Berlisensi & Berpengalaman
                        </li>
                        <li class="flex items-start text-sm text-gray-600">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            Peralatan Terawat & Steril
                        </li>
                         <li class="flex items-start text-sm text-gray-600">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            Jaminan Harga Terbaik
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>