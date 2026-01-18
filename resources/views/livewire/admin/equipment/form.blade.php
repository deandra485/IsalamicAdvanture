<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex mb-1" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </a>
                    </li>
                    <li><span class="text-gray-300">/</span></li>
                    <li><a href="{{ route('admin.equipment.index') }}" class="hover:text-indigo-600 transition-colors">Peralatan</a></li>
                    <li><span class="text-gray-300">/</span></li>
                    <li class="text-indigo-600 font-medium">{{ $equipment ? 'Edit' : 'Baru' }}</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                {{ $equipment ? 'Edit Peralatan' : 'Tambah Peralatan' }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">Kelola inventaris peralatan penyewaan Anda.</p>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200 flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 space-y-8">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Informasi Dasar
                        </h2>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Peralatan <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="nama_peralatan" 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all placeholder-gray-400"
                                placeholder="Contoh: Tenda Eiger Kapasitas 4 Orang">
                            @error('nama_peralatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select wire:model="category_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm appearance-none">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Merk / Brand</label>
                                <input type="text" wire:model="merk" 
                                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="Contoh: Eiger, Consina">
                                @error('merk') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Harga Sewa / Hari <span class="text-red-500">*</span></label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm font-semibold">Rp</span>
                                    </div>
                                    <input type="number" wire:model="harga_sewa_perhari" 
                                        class="w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="0">
                                </div>
                                @error('harga_sewa_perhari') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Stok Tersedia <span class="text-red-500">*</span></label>
                                <input type="number" wire:model="stok_tersedia" min="0"
                                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="0">
                                @error('stok_tersedia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Kondisi Fisik <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach(['baru' => 'green', 'baik' => 'blue', 'cukup baik' => 'yellow'] as $key => $color)
                                <label class="cursor-pointer relative">
                                    <input type="radio" wire:model.live="kondisi" value="{{ $key }}" class="peer sr-only">
                                    <div class="rounded-xl border-2 border-gray-200 p-4 text-center hover:border-gray-300 peer-checked:border-{{ $color }}-500 peer-checked:bg-{{ $color }}-50 transition-all duration-200">
                                        <span class="block text-sm font-bold capitalize text-gray-600 peer-checked:text-{{ $color }}-700">
                                            {{ $key }}
                                        </span>
                                    </div>
                                    <div class="absolute top-0 right-0 -mt-2 -mr-2 hidden peer-checked:block">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-{{ $color }}-500 ring-2 ring-white">
                                            <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                        </span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('kondisi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Detail & Deskripsi
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Lengkap</label>
                            <textarea wire:model="deskripsi" rows="4" 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="Jelaskan fitur utama, kelebihan, dan peruntukan alat ini..."></textarea>
                            @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Spesifikasi Teknis</label>
                            <textarea wire:model="spesifikasi" rows="4" 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm font-mono text-sm"
                                placeholder="- Berat: 2kg&#10;- Dimensi: 20x20x10cm&#10;- Bahan: Waterproof Polyester"></textarea>
                            @error('spesifikasi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Galeri Foto
                        </h2>
                    </div>
                    <div class="p-6">
                        @if(count($existingImages) > 0)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Foto Tersimpan</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($existingImages as $image)
                                <div wire:key="existing-{{ $image['id'] }}" class="group relative aspect-square bg-gray-100 rounded-lg overflow-hidden border {{ $primaryImageId == $image['id'] ? 'border-2 border-indigo-500 ring-2 ring-indigo-200' : 'border-gray-200' }}">
                                    <img src="{{ Storage::url($image['image_url']) }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                    
                                    @if($primaryImageId == $image['id'])
                                    <div class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] uppercase font-bold px-2 py-0.5 rounded shadow-sm">
                                        Utama
                                    </div>
                                    @endif

                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                                        @if($primaryImageId != $image['id'])
                                        <button type="button" wire:click="setPrimaryImage({{ $image['id'] }})" class="px-3 py-1 bg-white/90 text-gray-900 text-xs font-medium rounded-full hover:bg-white transition">
                                            Jadikan Utama
                                        </button>
                                        @endif
                                        <button type="button" wire:click="removeExistingImage({{ $image['id'] }})" wire:confirm="Hapus gambar ini?" class="p-2 bg-red-500/90 text-white rounded-full hover:bg-red-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Foto Baru</label>
                            
                            <div class="relative group">
                                <label for="file-upload" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-400 transition-all duration-200">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                        <p class="mb-1 text-sm text-gray-500 group-hover:text-indigo-600"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-400">PNG, JPG, GIF (Max 2MB/file)</p>
                                    </div>
                                    <input id="file-upload" type="file" wire:model="images" accept="image/*" multiple class="hidden" />
                                </label>
                                
                                <div wire:loading wire:target="images" class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-xl backdrop-blur-sm">
                                    <div class="flex items-center gap-2 text-indigo-600 font-medium">
                                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Mengupload...
                                    </div>
                                </div>
                            </div>
                            @error('images.*') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

                            @if($images)
                            <div class="mt-6 grid grid-cols-4 gap-4">
                                @foreach($images as $image)
                                <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-indigo-500/10"></div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="sticky top-6 space-y-6">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Publikasi</h3>
                        
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-sm font-medium text-gray-700">Tersedia untuk Disewa</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_available" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>

                        @if($equipment)
                        <div class="bg-gray-50 rounded-lg p-4 mb-6 space-y-3 border border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Booking</span>
                                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded-full">{{ $equipment->bookingItems->count() }}</span>
                            </div>
                            <div class="h-px bg-gray-200"></div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Dibuat</span>
                                <span class="font-medium text-gray-900">{{ $equipment->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Terakhir Update</span>
                                <span class="font-medium text-gray-900">{{ $equipment->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="space-y-3">
                            <button type="submit" wire:loading.attr="disabled" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <span wire:loading.remove wire:target="save">
                                    {{ $equipment ? 'Simpan Perubahan' : 'Terbitkan Peralatan' }}
                                </span>
                                <span wire:loading wire:target="save" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Processing...
                                </span>
                            </button>

                            <a href="{{ route('admin.equipment.index') }}" class="w-full flex justify-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Batal
                            </a>

                            @if($equipment)
                            <a href="{{ route('equipment.show', $equipment) }}" target="_blank" class="w-full flex justify-center items-center gap-2 py-2.5 px-4 rounded-lg text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Live Preview
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-blue-900">Tips Optimasi</h4>
                                <p class="mt-1 text-sm text-blue-700">
                                    Foto berkualitas tinggi meningkatkan peluang sewa hingga 30%. Pastikan pencahayaan cukup terang.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>