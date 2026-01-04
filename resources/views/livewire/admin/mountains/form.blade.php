<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.mountains.index') }}" class="hover:text-primary-600">Gunung</a>
            <span>/</span>
            <span class="text-gray-900">{{ $mountain ? 'Edit' : 'Tambah' }}</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">
            {{ $mountain ? 'Edit Gunung' : 'Tambah Gunung Baru' }}
        </h1>
    </div>

    <!-- Flash Messages -->
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
                        <!-- Nama Gunung -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Gunung <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="nama_gunung"
                                   class="input-field"
                                   placeholder="Contoh: Gunung Semeru">
                            @error('nama_gunung') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi & Ketinggian -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       wire:model="lokasi"
                                       class="input-field"
                                       placeholder="Contoh: Jawa Timur">
                                @error('lokasi') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ketinggian (mdpl) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       wire:model="ketinggian"
                                       class="input-field"
                                       placeholder="3676">
                                @error('ketinggian') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tingkat Kesulitan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tingkat Kesulitan <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-4 gap-3">
                                <label class="flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ $tingkat_kesulitan === 'mudah' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" wire:model.live="tingkat_kesulitan" value="mudah" class="sr-only">
                                    <span class="text-sm font-semibold {{ $tingkat_kesulitan === 'mudah' ? 'text-green-700' : 'text-gray-700' }}">
                                        Mudah
                                    </span>
                                </label>
                                <label class="flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ $tingkat_kesulitan === 'sedang' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" wire:model.live="tingkat_kesulitan" value="sedang" class="sr-only">
                                    <span class="text-sm font-semibold {{ $tingkat_kesulitan === 'sedang' ? 'text-yellow-700' : 'text-gray-700' }}">
                                        Sedang
                                    </span>
                                </label>
                                <label class="flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ $tingkat_kesulitan === 'sulit' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" wire:model.live="tingkat_kesulitan" value="sulit" class="sr-only">
                                    <span class="text-sm font-semibold {{ $tingkat_kesulitan === 'sulit' ? 'text-orange-700' : 'text-gray-700' }}">
                                        Sulit
                                    </span>
                                </label>
                                <label class="flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ $tingkat_kesulitan === 'sangat sulit' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" wire:model.live="tingkat_kesulitan" value="sangat sulit" class="sr-only">
                                    <span class="text-sm font-semibold {{ $tingkat_kesulitan === 'sangat sulit' ? 'text-red-700' : 'text-gray-700' }}">
                                        Sangat Sulit
                                    </span>
                                </label>
                            </div>
                            @error('tingkat_kesulitan') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea wire:model="deskripsi"
                                      rows="5"
                                      class="input-field"
                                      placeholder="Deskripsi lengkap tentang gunung..."></textarea>
                            @error('deskripsi') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Hiking Routes -->
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Jalur Pendakian</h2>
                        <button type="button"
                                wire:click="addRoute"
                                class="text-sm btn-primary">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Jalur
                        </button>
                    </div>

                    @if(count($routes) > 0)
                    <div class="space-y-4">
                        @foreach($routes as $index => $route)
                        <div wire:key="route-{{ $index }}" class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-semibold text-gray-900">Jalur {{ $index + 1 }}</h3>
                                <button type="button"
                                        wire:click="removeRoute({{ $index }})"
                                        wire:confirm="Hapus jalur ini?"
                                        class="text-red-600 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nama Jalur -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Nama Jalur <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           wire:model="routes.{{ $index }}.nama_jalur"
                                           class="input-field text-sm"
                                           placeholder="Contoh: Jalur Ranu Pane">
                                    @error("routes.{$index}.nama_jalur") 
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tingkat Kesulitan -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Tingkat Kesulitan <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="routes.{{ $index }}.tingkat_kesulitan" class="input-field text-sm">
                                        <option value="mudah">Mudah</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="sulit">Sulit</option>
                                        <option value="sangat sulit">Sangat Sulit</option>
                                    </select>
                                    @error("routes.{$index}.tingkat_kesulitan") 
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estimasi Waktu -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Estimasi Waktu (Hari) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           wire:model="routes.{{ $index }}.estimasi_waktu_hari"
                                           class="input-field text-sm"
                                           min="1">
                                    @error("routes.{$index}.estimasi_waktu_hari") 
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jarak -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Jarak (km)
                                    </label>
                                    <input type="number" 
                                           step="0.01"
                                           wire:model="routes.{{ $index }}.jarak_km"
                                           class="input-field text-sm"
                                           placeholder="10.5">
                                    @error("routes.{$index}.jarak_km") 
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="flex items-center">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model="routes.{{ $index }}.is_available"
                                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-gray-700">Jalur Tersedia</span>
                                    </label>
                                </div>

                                <!-- Deskripsi -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">
                                        Deskripsi Jalur
                                    </label>
                                    <textarea wire:model="routes.{{ $index }}.deskripsi_jalur"
                                              rows="2"
                                              class="input-field text-sm"
                                              placeholder="Deskripsi singkat jalur..."></textarea>
                                    @error("routes.{$index}.deskripsi_jalur") 
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <p class="text-sm">Belum ada jalur pendakian</p>
                        <button type="button"
                                wire:click="addRoute"
                                class="mt-3 text-sm text-primary-600 hover:text-primary-700 font-medium">
                            + Tambah Jalur Pertama
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Image Upload -->
                <div class="card">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Gambar Gunung</h3>
                    
                    @if($existingImage || $image)
                    <div class="mb-4">
                        @if($image)
                        <img src="{{ $image->temporaryUrl() }}" 
                             alt="Preview"
                             class="w-full h-48 object-cover rounded-lg">
                        @elseif($existingImage)
                        <img src="{{ Storage::url($existingImage) }}" 
                             alt="Current"
                             class="w-full h-48 object-cover rounded-lg">
                        @endif
                        
                        @if($existingImage && !$image)
                        <button type="button"
                                wire:click="removeImage"
                                wire:confirm="Hapus gambar?"
                                class="mt-2 text-sm text-red-600 hover:text-red-700">
                            Hapus Gambar
                        </button>
                        @endif
                    </div>
                    @endif

                    <label class="block">
                        <span class="sr-only">Choose image</span>
                        <input type="file" 
                               wire:model="image"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-primary-50 file:text-primary-700
                                      hover:file:bg-primary-100
                                      file:cursor-pointer cursor-pointer">
                    </label>
                    @error('image') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <div wire:loading wire:target="image" class="mt-2 text-sm text-gray-600">
                        Uploading...
                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        PNG, JPG atau GIF. Max 2MB.
                    </p>
                </div>

                <!-- Status -->
                <div class="card">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status</h3>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               wire:model="is_active"
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 w-5 h-5">
                        <span class="ml-3 text-sm font-medium text-gray-700">
                            Aktif (Tampil di Website)
                        </span>
                    </label>
                </div>

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
                                {{ $mountain ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="save">
                                Processing...
                            </span>
                        </button>

                        <a href="{{ route('admin.mountains.index') }}" 
                           class="btn-secondary w-full text-center block">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>