<div class="min-h-screen bg-slate-50 py-10 font-sans text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="text-sm font-medium text-slate-500 hover:text-emerald-600 transition">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <a href="{{ route('equipment.index') }}" class="text-sm font-medium text-slate-500 hover:text-emerald-600 transition">Peralatan</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <span class="text-sm font-medium text-emerald-600 truncate max-w-[200px]">{{ $equipment->nama_peralatan }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <div class="lg:col-span-8 space-y-8">
                
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-2 overflow-hidden">
                    <div class="relative group">
                        @if($equipment->images->count() > 0)
                            <img src="{{ Storage::url($equipment->primaryImage->image_url ?? $equipment->images->first()->image_url) }}" 
                                 alt="{{ $equipment->nama_peralatan }}"
                                 class="w-full h-[400px] md:h-[500px] object-cover rounded-2xl shadow-inner">
                        @else
                            <div class="w-full h-[400px] bg-slate-100 rounded-2xl flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Tidak ada gambar</span>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md border border-white/20 shadow-sm
                                {{ $equipment->kondisi === 'baru' ? 'bg-emerald-500/90 text-white' : 'bg-blue-500/90 text-white' }}">
                                <span class="w-2 h-2 rounded-full bg-white mr-2 animate-pulse"></span>
                                Kondisi: {{ ucfirst($equipment->kondisi) }}
                            </span>
                        </div>
                    </div>

                    @if($equipment->images->count() > 1)
                    <div class="grid grid-cols-5 gap-3 mt-3 px-1">
                        @foreach($equipment->images->take(5) as $image)
                        <div class="relative aspect-square cursor-pointer group rounded-xl overflow-hidden ring-2 ring-transparent hover:ring-emerald-500 transition-all">
                            <img src="{{ Storage::url($image->image_url) }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div>
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-600 uppercase tracking-wide">
                                    {{ $equipment->category->nama_kategori }}
                                </span>
                                @if($equipment->merk)
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-600 uppercase tracking-wide">
                                    {{ $equipment->merk }}
                                </span>
                                @endif
                            </div>
                            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                {{ $equipment->nama_peralatan }}
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Detail Produk
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-8">
                        @if($equipment->deskripsi)
                        <div>
                            <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Deskripsi</h4>
                            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                                <p class="whitespace-pre-line">{{ $equipment->deskripsi }}</p>
                            </div>
                        </div>
                        @endif

                        @if($equipment->deskripsi && $equipment->spesifikasi)
                        <hr class="border-slate-100">
                        @endif

                        @if($equipment->spesifikasi)
                        <div>
                            <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Spesifikasi Teknis</h4>
                            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100">
                                <p class="whitespace-pre-line text-slate-700 font-mono text-sm leading-7">{{ $equipment->spesifikasi }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-6 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                        
                        <div class="p-6 bg-gradient-to-br from-emerald-50 to-white border-b border-emerald-100/50">
                            <p class="text-sm text-slate-500 font-medium mb-1">Harga Sewa</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-extrabold text-emerald-600">Rp {{ number_format($equipment->harga_sewa_perhari, 0, ',', '.') }}</span>
                                <span class="text-slate-500 font-medium">/ hari</span>
                            </div>
                        </div>

                        <div class="px-6 pt-6">
                            @if(session()->has('success'))
                            <div class="p-4 bg-green-50 text-green-700 text-sm rounded-xl border border-green-100 flex items-start gap-2 mb-4">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ session('success') }}
                            </div>
                            @endif

                            @if(session()->has('error'))
                            <div class="p-4 bg-red-50 text-red-700 text-sm rounded-xl border border-red-100 flex items-start gap-2 mb-4">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ session('error') }}
                            </div>
                            @endif
                        </div>

                        <form wire:submit="addToCart" class="p-6 pt-2">
                            <div class="space-y-5">
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-1">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Mulai</label>
                                        <input type="date" 
                                            wire:model.live="tanggalMulai"
                                            min="{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                                            class="block w-full rounded-xl border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50">
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Selesai</label>
                                        <input type="date" 
                                            wire:model.live="tanggalSelesai"
                                            min="{{ Carbon\Carbon::tomorrow()->addDay()->format('Y-m-d') }}"
                                            class="block w-full rounded-xl border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50">
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide">Jumlah Unit</label>
                                        <span class="text-xs font-medium {{ $availableStock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                            Stok: {{ $availableStock }}
                                        </span>
                                    </div>
                                    <div class="relative">
                                        <input type="number" 
                                            wire:model.live="quantity"
                                            min="1"
                                            max="{{ $availableStock }}"
                                            class="block w-full rounded-xl border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500 pl-4 pr-10">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-slate-400 text-xs">Unit</span>
                                        </div>
                                    </div>
                                </div>

                                @if($durasi > 0)
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 space-y-3 animate-in fade-in slide-in-from-top-2 duration-300">
                                    <div class="flex justify-between text-sm text-slate-600">
                                        <span>Durasi Sewa</span>
                                        <span class="font-semibold">{{ $durasi }} Hari</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-slate-600">
                                        <span>Jumlah Barang</span>
                                        <span class="font-semibold">{{ $quantity }} Unit</span>
                                    </div>
                                    <div class="border-t border-slate-200 pt-3 flex justify-between items-center">
                                        <span class="font-bold text-slate-900">Total Biaya</span>
                                        <span class="text-lg font-bold text-emerald-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @endif

                                <button type="submit"
                                    {{ ($availableStock < 1 || $durasi < 1) ? 'disabled' : '' }}
                                    class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white transition-all duration-200 {{ $availableStock < 1 ? 'bg-slate-300 cursor-not-allowed shadow-none' : 'bg-emerald-600 hover:bg-emerald-700 hover:-translate-y-0.5 shadow-emerald-500/30' }}">
                                    
                                    @if($availableStock < 1)
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                        <span>Stok Habis</span>
                                    @else
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span>Booking Sekarang</span>
                                    @endif
                                </button>
                                
                                <p class="text-xs text-center text-slate-400 mt-2">
                                    Aman & Terpercaya. Pembayaran dilakukan di langkah selanjutnya.
                                </p>
                            </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                            <svg class="w-6 h-6 mx-auto text-emerald-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[10px] text-slate-500 font-medium">Steril</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                            <svg class="w-6 h-6 mx-auto text-emerald-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[10px] text-slate-500 font-medium">Tepat Waktu</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                            <svg class="w-6 h-6 mx-auto text-emerald-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                            <span class="text-[10px] text-slate-500 font-medium">Kualitas</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>