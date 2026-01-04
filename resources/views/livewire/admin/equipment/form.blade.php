<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.equipment.index') }}" class="hover:text-primary-600">Peralatan</a>
            <span>/</span>
            <span class="text-gray-900">{{ $equipment ? 'Edit' : 'Tambah' }}</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">
            {{ $equipment ? 'Edit Peralatan' : 'Tambah Peralatan Baru' }}
        </h1>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200">
        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
    </div>
    @endif

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="card">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Dasar</h2>
                    
                    <div class="space-y-4">
                        <!-- Nama Peralatan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Peralatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="nama_peralatan"
                                   class="input-field"
                                   placeholder="Contoh: Tenda Kapasitas 2 Orang">
                            @error('nama_peralatan') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category & Merk -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="category_id" class="input-field">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Merk
                                </label>
                                <input type="text" 
                                       wire:model="merk"
                                       class="input-field"
                                       placeholder="Contoh: Eiger">
                                @error('merk') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Harga & Stok -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Sewa/Hari <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" 
                                           wire:model="harga_sewa_perhari"
                                           class="input-field pl-12"
                                           placeholder="50000">
                                </div>
                                @error('harga_sewa_perhari') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Stok Tersedia <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       wire:model="stok_tersedia"
                                       class="input-field"
                                       placeholder="10"
                                       min="0">
                                @error('stok_tersedia') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kondisi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kondisi <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ $kondisi === 'baru' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" wire:model.live="kondisi" value="baru" class="sr-only">
                                    <span class="text-sm font-semibold {{ $kondisi === 'baru' ? 'text-green-700' : 'text-gray-700' }}">
                                        Baru
                                    </span>
                                </label>
                                <label class="flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ $kondisi === 'baik' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" wire:model.live="kondisi" value="baik" class="sr-only">
                                    <span class="text-sm font-semibold {{ $kondisi === 'baik' ? 'text-blue-700' : 'text-gray-700' }}">
                                        Baik
                                    </span>
                                </label>
                                <label class="flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ $kondisi === 'cukup baik' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" wire:model.live="kondisi" value="cukup baik" class="sr-only">
                                    <span class="text-sm font-semibold {{ $kondisi === 'cukup baik' ? 'text-yellow-700' : 'text-gray-700' }}">
                                        Cukup Baik
                                    </span>
                                </label>
                            </div>
                            @error('kondisi') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea wire:model="deskripsi"
                                      rows="4"
                                      class="input-field"
                                      placeholder="Deskripsi lengkap peralatan..."></textarea>
                            @error('deskripsi') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Spesifikasi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Spesifikasi
                            </label>
                            <textarea wire:model="spesifikasi"
                                      rows="4"
                                      class="input-field"
                                      placeholder="Detail spesifikasi teknis..."></textarea>
                            @error('spesifikasi') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Multi Images -->
                <div class="card">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Foto Peralatan</h2>
                    
                    <!-- Existing Images -->
                    @if(count($existingImages) > 0)
                    <div class="grid grid-cols-4 gap-4 mb-4">
                        @foreach($existingImages as $index => $image)
                        <div wire:key="existing-{{ $image['id'] }}" class="relative group">
                            <img src="{{ Storage::url($image['image_url']) }}" 
                                 alt="Image"
                                 class="w-full h-32 object-cover rounded-lg {{ $primaryImageId == $image['id'] ? 'ring-4 ring-primary-500' : '' }}">
                            
                            <!-- Primary Badge -->
                            @if($primaryImageId == $image['id'])
                            <div class="absolute top-2 left-2 px-2 py-1 bg-primary-600 text-white text-xs font-bold rounded">
                                Primary
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                @if($primaryImageId != $image['id'])
                                <button type="button"
                                        wire:click="setPrimaryImage({{ $image['id'] }})"
                                        class="px-2 py-1 bg-white text-gray-900 text-xs rounded hover:bg-gray-100">
                                    Set Primary
                                </button>
                                @endif
                                <button type="button"
                                        wire:click="removeExistingImage({{ $image['id'] }})"
                                        wire:confirm="Hapus gambar ini?"
                                        class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Upload New Images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Gambar Baru (Max 5 gambar)
                        </label>
                        <input type="file" 
                               wire:model="images"
                               accept="image/*"
                               multiple
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-primary-50 file:text-primary-700
                                      hover:file:bg-primary-100
                                      file:cursor-pointer cursor-pointer">
                        @error('images.*') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <div wire:loading wire:target="images" class="mt-2 text-sm text-gray-600">
                            Uploading...
                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            PNG, JPG atau GIF. Max 2MB per file. Gambar pertama akan menjadi primary.
                        </p>
                    </div>

                    <!-- Preview New Images -->
                    @if($images)
                    <div class="mt-4 grid grid-cols-4 gap-4">
                        @foreach($images as $image)
                        <img src="{{ $image->temporaryUrl() }}" 
                             class="w-full h-32 object-cover rounded-lg border-2 border-primary-300">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status -->
                <div class="card">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status</h3>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               wire:model="is_available"
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 w-5 h-5">
                        <span class="ml-3 text-sm font-medium text-gray-700">
                            Tersedia untuk Disewa
                        </span>
                    </label>
                </div>

                <!-- Quick Stats -->
                @if($equipment)
                <div class="card">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Booking:</span>
                            <span class="font-semibold text-gray-900">{{ $equipment->bookingItems->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="font-semibold text-gray-900">{{ $equipment->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Update:</span>
                            <span class="font-semibold text-gray-900">{{ $equipment->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="card">
                    <div class="space-y-3">
                        <button type="submit" 
                                class="btn-primary w-full"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $equipment ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="save">
                                Processing...
                            </span>
                        </button>

                        <a href="{{ route('admin.equipment.index') }}" 
                           class="btn-secondary w-full text-center block">
                            Batal
                        </a>

                        @if($equipment)
                        <a href="{{ route('equipment.show', $equipment) }}" 
                           target="_blank"
                           class="w-full py-2 px-4 bg-blue-50 text-blue-600 rounded-lg font-semibold text-center hover:bg-blue-100 transition block">
                            Preview
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>