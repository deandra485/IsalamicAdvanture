<div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Peralatan</h1>
            <p class="text-gray-600 mt-1">Kelola peralatan dan stok inventory</p>
        </div>
        <a href="{{ route('admin.equipment.create') }}" class="btn-primary">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Peralatan
        </a>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200">
        <div class="flex">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Bulk Actions Bar -->
    @if(count($selectedItems) > 0)
    <div class="mb-6 card bg-primary-50 border-2 border-primary-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold text-primary-900">{{ count($selectedItems) }} item dipilih</span>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="bulkActivate"
                        wire:confirm="Aktifkan {{ count($selectedItems) }} item terpilih?"
                        class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                    Aktifkan
                </button>
                <button wire:click="bulkDeactivate"
                        wire:confirm="Nonaktifkan {{ count($selectedItems) }} item terpilih?"
                        class="px-4 py-2 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition">
                    Nonaktifkan
                </button>
                <button wire:click="bulkDelete"
                        wire:confirm="HAPUS {{ count($selectedItems) }} item terpilih? Tindakan ini tidak bisa dibatalkan!"
                        class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Filters -->
    <div class="card mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <input type="text" 
                       wire:model.live.debounce.500ms="search"
                       placeholder="Cari peralatan..."
                       class="input-field">
            </div>

            <!-- Category -->
            <div>
                <select wire:model.live="categoryFilter" class="input-field">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <select wire:model.live="statusFilter" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="1">Tersedia</option>
                    <option value="0">Tidak Tersedia</option>
                </select>
            </div>

            <!-- Kondisi -->
            <div>
                <select wire:model.live="kondisiFilter" class="input-field">
                    <option value="">Semua Kondisi</option>
                    <option value="baru">Baru</option>
                    <option value="baik">Baik</option>
                    <option value="cukup baik">Cukup Baik</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <select wire:model.live="sortBy" class="input-field">
                    <option value="created_at">Terbaru</option>
                    <option value="nama_peralatan">Nama A-Z</option>
                    <option value="harga_sewa_perhari">Harga</option>
                    <option value="stok_tersedia">Stok</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" 
                                   wire:model.live="selectAll"
                                   class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Peralatan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga/Hari
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stok
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kondisi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($equipment as $item)
                    <tr wire:key="equipment-{{ $item->id }}" class="{{ in_array($item->id, $selectedItems) ? 'bg-primary-50' : '' }}">
                        <!-- Checkbox -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" 
                                   wire:model.live="selectedItems"
                                   value="{{ $item->id }}"
                                   class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>

                        <!-- Equipment -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($item->primaryImage)
                                <img src="{{ Storage::url($item->primaryImage->image_url) }}" 
                                     alt="{{ $item->nama_peralatan }}"
                                     class="w-12 h-12 rounded-lg object-cover mr-3">
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama_peralatan }}</div>
                                    @if($item->merk)
                                    <div class="text-xs text-gray-500">{{ $item->merk }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                {{ $item->category->nama_kategori }}
                            </span>
                        </td>

                        <!-- Price -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($item->harga_sewa_perhari, 0, ',', '.') }}
                            </div>
                        </td>

                        <!-- Stock -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold {{ $item->stok_tersedia > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item->stok_tersedia }} unit
                            </div>
                        </td>

                        <!-- Kondisi -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $item->kondisi === 'baru' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $item->kondisi === 'baik' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $item->kondisi === 'cukup baik' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                {{ ucfirst($item->kondisi) }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="toggleStatus({{ $item->id }})"
                                    wire:confirm="Ubah status peralatan ini?"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors
                                           {{ $item->is_available ? 'bg-green-500' : 'bg-gray-300' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform
                                             {{ $item->is_available ? 'translate-x-6' : 'translate-x-1' }}">
                                </span>
                            </button>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('equipment.show', $item) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Preview">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.equipment.edit', $item) }}"
                                   class="text-primary-600 hover:text-primary-900"
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button wire:click="deleteEquipment({{ $item->id }})"
                                        wire:confirm="Yakin ingin menghapus peralatan ini?"
                                        class="text-red-600 hover:text-red-900"
                                        title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-gray-600">Tidak ada data peralatan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($equipment->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $equipment->links() }}
        </div>
        @endif
    </div>
</div>