<div class="min-h-screen bg-gray-50/50 pb-12">
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between py-4 gap-4">
                <div>
                    <nav class="flex mb-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm text-gray-500">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                            <li><svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg></li>
                            <li><a href="{{ route('admin.mountains.index') }}" class="hover:text-indigo-600 transition-colors">Gunung</a></li>
                            <li><svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg></li>
                            <li class="font-medium text-gray-900">{{ $mountain ? 'Edit' : 'Tambah Baru' }}</li>
                        </ol>
                    </nav>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                        {{ $mountain ? 'Edit Data Gunung' : 'Tambah Gunung Baru' }}
                    </h1>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.mountains.index') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        Batal
                    </a>
                    <button type="button" wire:click="save" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <span wire:loading.remove wire:target="save">Simpan Data</span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        
        @if (session()->has('error'))
        <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-100 flex items-start gap-3 animate-fade-in-down">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3>
                <p class="text-sm text-red-600 mt-1">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <form wire:submit="save">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <div class="lg:col-span-8 space-y-8">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900">Informasi Dasar</h2>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Gunung <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_gunung" 
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 transition-all hover:border-indigo-300" 
                                    placeholder="Contoh: Gunung Semeru">
                                @error('nama_gunung') <p class="mt-2 text-sm text-red-600 flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <input type="text" wire:model="lokasi" 
                                            class="block w-full pl-10 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3" 
                                            placeholder="Jawa Timur">
                                    </div>
                                    @error('lokasi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ketinggian (mdpl) <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                        </div>
                                        <input type="number" wire:model="ketinggian" 
                                            class="block w-full pl-10 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3" 
                                            placeholder="3676">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">mdpl</span>
                                        </div>
                                    </div>
                                    @error('ketinggian') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Tingkat Kesulitan <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach([
                                        'mudah' => ['color' => 'emerald', 'label' => 'Mudah', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'sedang' => ['color' => 'yellow', 'label' => 'Sedang', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                                        'sulit' => ['color' => 'orange', 'label' => 'Sulit', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                                        'sangat sulit' => ['color' => 'red', 'label' => 'Sangat Sulit', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
                                    ] as $val => $props)
                                    <label class="cursor-pointer group">
                                        <input type="radio" wire:model.live="tingkat_kesulitan" value="{{ $val }}" class="peer sr-only">
                                        <div class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-gray-200 transition-all duration-200 
                                            hover:border-{{ $props['color'] }}-300 hover:bg-{{ $props['color'] }}-50
                                            peer-checked:border-{{ $props['color'] }}-500 peer-checked:bg-{{ $props['color'] }}-50 peer-checked:shadow-md">
                                            
                                            <div class="mb-2 text-{{ $props['color'] }}-500">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $props['icon'] }}"/></svg>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-{{ $props['color'] }}-700">{{ $props['label'] }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                @error('tingkat_kesulitan') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Lengkap</label>
                                <textarea wire:model="deskripsi" rows="6" 
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3"
                                    placeholder="Ceritakan tentang keindahan, sejarah, dan karakteristik gunung ini..."></textarea>
                                @error('deskripsi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">Jalur Pendakian</h2>
                                    <p class="text-sm text-gray-500">Kelola titik awal dan rute pendakian.</p>
                                </div>
                            </div>
                            <button type="button" wire:click="addRoute" 
                                class="inline-flex items-center px-4 py-2 border border-indigo-200 shadow-sm text-sm font-medium rounded-lg text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Tambah Jalur
                            </button>
                        </div>

                        <div class="p-6 bg-gray-50/30">
                            @if(count($routes) > 0)
                                <div class="space-y-6">
                                    @foreach($routes as $index => $route)
                                    <div wire:key="route-{{ $index }}" class="group bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-indigo-500 rounded-l-xl"></div>
                                        
                                        <div class="flex justify-between items-start mb-4 pl-3">
                                            <div class="flex items-center gap-2">
                                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold ring-2 ring-white">
                                                    {{ $index + 1 }}
                                                </span>
                                                <h3 class="font-semibold text-gray-900">Detail Jalur</h3>
                                            </div>
                                            <button type="button" wire:click="removeRoute({{ $index }})" wire:confirm="Yakin ingin menghapus jalur ini?" 
                                                class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-5 pl-3">
                                            <div class="md:col-span-8">
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Jalur</label>
                                                <input type="text" wire:model="routes.{{ $index }}.nama_jalur" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: Via Ranu Pane">
                                                @error("routes.{$index}.nama_jalur") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div class="md:col-span-4">
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kesulitan</label>
                                                <select wire:model="routes.{{ $index }}.tingkat_kesulitan" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="mudah">Mudah</option>
                                                    <option value="sedang">Sedang</option>
                                                    <option value="sulit">Sulit</option>
                                                    <option value="sangat sulit">Sangat Sulit</option>
                                                </select>
                                            </div>

                                            <div class="md:col-span-4">
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Waktu (Hari)</label>
                                                <input type="number" wire:model="routes.{{ $index }}.estimasi_waktu_hari" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="2">
                                            </div>
                                            <div class="md:col-span-4">
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jarak (KM)</label>
                                                <input type="number" step="0.1" wire:model="routes.{{ $index }}.jarak_km" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="10.5">
                                            </div>

                                            <div class="md:col-span-4 flex items-end pb-2">
                                                 <label class="inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" wire:model="routes.{{ $index }}.is_available" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-5 w-5">
                                                    <span class="ml-2 text-sm text-gray-700 font-medium">Jalur Tersedia</span>
                                                </label>
                                            </div>

                                            <div class="md:col-span-12">
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Info Tambahan</label>
                                                <textarea wire:model="routes.{{ $index }}.deskripsi_jalur" rows="2" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Catatan khusus untuk jalur ini..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 px-4 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada jalur pendakian</h3>
                                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan satu jalur utama.</p>
                                    <div class="mt-6">
                                        <button type="button" wire:click="addRoute" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Buat Jalur Pertama
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-8">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Status Publikasi</h3>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <span class="text-sm font-medium text-gray-700">Tampilkan di Web</span>
                            
                            <button type="button" wire:click="$toggle('is_active')" 
                                class="{{ $is_active ? 'bg-indigo-600' : 'bg-gray-200' }} relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="{{ $is_active ? 'true' : 'false' }}">
                                <span class="{{ $is_active ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Jika dimatikan, gunung ini tidak akan muncul di halaman pencarian user.</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Gambar Utama</h3>
                        
                        @if($existingImage || $image)
                            <div class="relative group rounded-xl overflow-hidden shadow-md mb-4 aspect-video bg-gray-100">
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($existingImage)
                                    <img src="{{ Storage::url($existingImage) }}" class="w-full h-full object-cover">
                                @endif
                                
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" wire:click="removeImage" class="p-2 bg-red-600 rounded-full text-white hover:bg-red-700 transition-colors shadow-lg" title="Hapus Gambar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 hover:bg-indigo-50/30 transition-all cursor-pointer relative">
                            <input type="file" wire:model="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        Upload file
                                    </span>
                                    <p class="pl-1">atau drag & drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        <div wire:loading wire:target="image" class="mt-2 w-full">
                            <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-600 animate-pulse w-full"></div>
                            </div>
                            <p class="text-xs text-center text-gray-500 mt-1">Mengupload...</p>
                        </div>
                        @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="block lg:hidden">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Data
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>