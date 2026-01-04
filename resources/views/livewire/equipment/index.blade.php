<div class="min-h-screen bg-slate-50 font-sans text-slate-900 pb-20">
    
    <div class="bg-gradient-to-r from-emerald-900 to-emerald-700 pt-16 pb-20 px-4 sm:px-6 lg:px-8 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2">
                Sewa Peralatan
            </h1>
            <p class="text-emerald-100 text-lg max-w-2xl">
                Perlengkapan berkualitas, steril, dan siap menemani petualanganmu menuju puncak.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10">
        
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 p-5 mb-10 border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                
                <div class="md:col-span-4 lg:col-span-5 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.500ms="search"
                           class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition sm:text-sm" 
                           placeholder="Cari tenda, carrier, sepatu...">
                </div>

                <div class="md:col-span-3 lg:col-span-2 relative">
                    <select wire:model.live="category" class="block w-full pl-3 pr-10 py-3 text-base border-slate-200 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-xl bg-slate-50">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama_kategori }} ({{ $cat->equipment_count }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3 lg:col-span-2 relative">
                    <select wire:model.live="kondisi" class="block w-full pl-3 pr-10 py-3 text-base border-slate-200 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-xl bg-slate-50">
                        <option value="">Semua Kondisi</option>
                        <option value="baru">Baru</option>
                        <option value="baik">Baik</option>
                        <option value="cukup baik">Cukup Baik</option>
                    </select>
                </div>

                <div class="md:col-span-2 lg:col-span-3 relative">
                    <select wire:model.live="sortBy" class="block w-full pl-3 pr-10 py-3 text-base border-slate-200 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-xl bg-slate-50">
                        <option value="nama_peralatan">Nama (A-Z)</option>
                        <option value="harga_sewa_perhari">Harga Termurah</option>
                        <option value="created_at">Terbaru</option>
                    </select>
                </div>
            </div>

            @if($search || $category || $kondisi)
            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end">
                <button wire:click="$set('search', ''); $set('category', ''); $set('kondisi', '');" 
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-emerald-700 bg-emerald-100 hover:bg-emerald-200 focus:outline-none transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset Filter
                </button>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            @forelse($equipment as $item)
            <div class="group relative bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full" wire:key="equipment-{{ $item->id }}">
                
                <a href="{{ route('equipment.show', $item) }}" class="absolute inset-0 z-10"></a>

                <div class="aspect-[4/3] w-full overflow-hidden rounded-t-2xl relative bg-slate-100">
                    <div class="absolute top-3 left-3 z-20 flex flex-col gap-2">
                         <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold backdrop-blur-md shadow-sm border border-white/20
                            {{ $item->kondisi === 'baru' ? 'bg-emerald-500/90 text-white' : '' }}
                            {{ $item->kondisi === 'baik' ? 'bg-blue-500/90 text-white' : '' }}
                            {{ $item->kondisi === 'cukup baik' ? 'bg-orange-500/90 text-white' : '' }}">
                            {{ ucfirst($item->kondisi) }}
                        </span>
                    </div>

                    @if($item->primaryImage)
                    <img src="{{ Storage::url($item->primaryImage->image_url) }}" 
                         alt="{{ $item->nama_peralatan }}"
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500 ease-in-out">
                    @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs font-medium">No Image</span>
                    </div>
                    @endif
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <div class="mb-1">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            {{ $item->category->nama_kategori }}
                        </span>
                    </div>
                    
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 mb-1">
                        {{ $item->nama_peralatan }}
                    </h3>
                    
                    @if($item->merk)
                    <p class="text-xs text-slate-500 mb-4">{{ $item->merk }}</p>
                    @else
                    <div class="mb-4"></div> @endif
                    
                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-emerald-600">
                                Rp {{ number_format($item->harga_sewa_perhari, 0, ',', '.') }}
                            </p>
                            <span class="text-[10px] text-slate-400 font-medium">/ 24 JAM</span>
                        </div>
                        
                        <div class="flex items-center">
                            @if($item->stok_tersedia > 0)
                                <div class="flex items-center text-xs font-medium text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">
                                    <span class="relative flex h-2 w-2 mr-1.5">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    {{ $item->stok_tersedia }} Stok
                                </div>
                            @else
                                <div class="flex items-center text-xs font-medium text-red-700 bg-red-50 px-2 py-1 rounded-lg border border-red-100">
                                    <span class="h-2 w-2 rounded-full bg-red-500 mr-1.5"></span>
                                    Habis
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-100 mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Peralatan tidak ditemukan</h3>
                <p class="text-slate-500 max-w-sm mx-auto">
                    Coba ubah kata kunci pencarian atau reset filter kategori untuk menemukan alat yang kamu butuhkan.
                </p>
                <button wire:click="$set('search', ''); $set('category', ''); $set('kondisi', '');" 
                        class="mt-6 px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/30">
                    Lihat Semua Peralatan
                </button>
            </div>
            @endforelse
        </div>

        @if($equipment->hasPages())
        <div class="mt-12">
            {{ $equipment->links() }} 
            </div>
        @endif
    </div>
</div>