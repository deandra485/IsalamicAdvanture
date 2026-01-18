<div class="p-4 min-h-screen bg-gray-50 lg:p-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Manajemen Peralatan
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau stok, kondisi, dan ketersediaan aset dalam satu tampilan.
            </p>
        </div>
        
        <a href="{{ route('admin.equipment.create') }}" 
           class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white transition-all bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 shadow-md shadow-indigo-200">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Peralatan Baru
        </a>
    </div>

    <div class="space-y-4 mb-6">
        @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition 
             class="flex items-center p-4 text-sm text-green-800 border border-green-200 rounded-lg bg-green-50 shadow-sm" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>{{ session('success') }}</div>
            <button @click="show = false" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        @endif

        @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-transition
             class="flex items-center p-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-50 shadow-sm" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div>{{ session('error') }}</div>
        </div>
        @endif
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        
        <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            @if(count($selectedItems) > 0)
            <div class="flex flex-wrap items-center justify-between p-4 mb-4 bg-indigo-50 border border-indigo-100 rounded-lg animate-fade-in-down">
                <div class="flex items-center space-x-3">
                    <span class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-full">
                        <span class="text-sm font-bold text-indigo-600">{{ count($selectedItems) }}</span>
                    </span>
                    <span class="text-sm font-medium text-indigo-900">Item dipilih</span>
                </div>
                <div class="flex space-x-2">
                    <button wire:click="bulkActivate" wire:confirm="Aktifkan item terpilih?" class="px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 rounded hover:bg-green-200 transition">Aktifkan</button>
                    <button wire:click="bulkDeactivate" wire:confirm="Nonaktifkan item terpilih?" class="px-3 py-1.5 text-xs font-medium text-orange-700 bg-orange-100 rounded hover:bg-orange-200 transition">Nonaktifkan</button>
                    <button wire:click="bulkDelete" wire:confirm="HAPUS item terpilih?" class="px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded hover:bg-red-200 transition">Hapus</button>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4">
                <div class="lg:col-span-4 relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search" 
                           class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400" 
                           placeholder="Cari nama alat, merk...">
                </div>

                <div class="lg:col-span-2">
                    <select wire:model.live="categoryFilter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <select wire:model.live="statusFilter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif / Tersedia</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <select wire:model.live="kondisiFilter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="">Semua Kondisi</option>
                        <option value="baru">Baru</option>
                        <option value="baik">Baik</option>
                        <option value="cukup baik">Cukup Baik</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <select wire:model.live="sortBy" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="created_at">Terbaru</option>
                        <option value="nama_peralatan">Nama (A-Z)</option>
                        <option value="harga_sewa_perhari">Harga Termurah</option>
                        <option value="stok_tersedia">Stok Terbanyak</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="p-4 w-4">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="selectAll" 
                                       class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 font-semibold">Peralatan</th>
                        <th scope="col" class="px-6 py-3 font-semibold text-center">Stok</th>
                        <th scope="col" class="px-6 py-3 font-semibold">Harga / Hari</th>
                        <th scope="col" class="px-6 py-3 font-semibold">Status & Kondisi</th>
                        <th scope="col" class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($equipment as $item)
                    <tr wire:key="row-{{ $item->id }}" class="bg-white hover:bg-gray-50 transition-colors duration-150 {{ in_array($item->id, $selectedItems) ? 'bg-indigo-50/30' : '' }}">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="selectedItems" value="{{ $item->id }}" 
                                       class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-12 h-12 relative group">
                                    @if($item->primaryImage)
                                        <img class="w-12 h-12 rounded-lg object-cover shadow-sm border border-gray-200 group-hover:scale-105 transition-transform" src="{{ Storage::url($item->primaryImage->image_url) }}" alt="{{ $item->nama_peralatan }}">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900 hover:text-indigo-600 transition-colors cursor-pointer">
                                        {{ $item->nama_peralatan }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        @if($item->merk)
                                            <span class="text-xs text-gray-500 font-medium">{{ $item->merk }}</span>
                                            <span class="text-gray-300">•</span>
                                        @endif
                                        <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">
                                            {{ $item->category->nama_kategori }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($item->stok_tersedia > 5)
                                <span class="px-2.5 py-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full">
                                    {{ $item->stok_tersedia }} Unit
                                </span>
                            @elseif($item->stok_tersedia > 0)
                                <span class="px-2.5 py-1 text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-200 rounded-full">
                                    Sisa {{ $item->stok_tersedia }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 border border-red-200 rounded-full">
                                    Habis
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900 font-mono">
                                Rp {{ number_format($item->harga_sewa_perhari, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">per hari</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center">
                                    <button wire:click="toggleStatus({{ $item->id }})"
                                            wire:confirm="Ubah status ketersediaan?"
                                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 {{ $item->is_available ? 'bg-green-500' : 'bg-gray-200' }}" 
                                            role="switch">
                                        <span class="sr-only">Use setting</span>
                                        <span aria-hidden="true" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $item->is_available ? 'translate-x-4' : 'translate-x-0' }}"></span>
                                    </button>
                                    <span class="ml-2 text-xs text-gray-500">{{ $item->is_available ? 'Aktif' : 'Nonaktif' }}</span>
                                </div>
                                
                                <div>
                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded border 
                                        {{ $item->kondisi === 'baru' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                        {{ $item->kondisi === 'baik' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                        {{ $item->kondisi === 'cukup baik' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}">
                                        Kondisi: {{ ucfirst($item->kondisi) }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('equipment.show', $item) }}" target="_blank" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors group relative" title="Lihat">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                
                                <a href="{{ route('admin.equipment.edit', $item) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                
                                <button wire:click="deleteEquipment({{ $item->id }})" wire:confirm="Yakin ingin menghapus {{ $item->nama_peralatan }}?" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Belum ada peralatan</h3>
                                <p class="text-gray-500 mt-1 max-w-sm">Data peralatan yang Anda cari tidak ditemukan atau belum ditambahkan.</p>
                                <a href="{{ route('admin.equipment.create') }}" class="mt-4 text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                    + Tambah Peralatan Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($equipment->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $equipment->links() }}
        </div>
        @endif
    </div>
</div>