<div class="min-h-screen p-4 bg-gray-50 lg:p-8">
    
    <div class="flex flex-col gap-4 mb-8 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Manajemen Gunung
            </h1>
            <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                <span>Kelola database gunung, jalur pendakian, dan status aktif.</span>
            </div>
        </div>
        
        <a href="{{ route('admin.mountains.create') }}" 
           class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white transition-all bg-emerald-600 border border-transparent rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-100 shadow-lg shadow-emerald-100">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Gunung Baru
        </a>
    </div>

    <div class="space-y-4 mb-6">
        @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
             class="flex items-center p-4 text-emerald-800 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm">
            <svg class="flex-shrink-0 w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm font-medium">{{ session('success') }}</div>
            <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endif

        @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
             class="flex items-center p-4 text-red-800 bg-red-50 border border-red-100 rounded-xl shadow-sm">
            <svg class="flex-shrink-0 w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm font-medium">{{ session('error') }}</div>
        </div>
        @endif
    </div>

    <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
        
        <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4">
                <div class="lg:col-span-5 relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.500ms="search"
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm placeholder-gray-400"
                           placeholder="Cari nama gunung atau lokasi...">
                </div>

                <div class="lg:col-span-2">
                    <select wire:model.live="statusFilter" class="block w-full py-2.5 border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <select wire:model.live="tingkatKesulitanFilter" class="block w-full py-2.5 border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">Tingkat Kesulitan</option>
                        <option value="mudah">Mudah</option>
                        <option value="sedang">Sedang</option>
                        <option value="sulit">Sulit</option>
                        <option value="sangat sulit">Sangat Sulit</option>
                    </select>
                </div>

                <div class="lg:col-span-3">
                    <select wire:model.live="sortBy" class="block w-full py-2.5 border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="created_at">Urutkan: Terbaru</option>
                        <option value="nama_gunung">Urutkan: Nama (A-Z)</option>
                        <option value="ketinggian">Urutkan: Ketinggian</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Gunung</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Detail Lokasi</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kesulitan</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Info Pendakian</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mountains as $mountain)
                    <tr wire:key="mountain-{{ $mountain->id }}" class="bg-white hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-12 h-12 relative group">
                                    @if($mountain->image_url)
                                        <img class="w-12 h-12 rounded-lg object-cover shadow-sm border border-gray-200 group-hover:scale-105 transition-transform duration-300" 
                                             src="{{ Storage::url($mountain->image_url) }}" 
                                             alt="{{ $mountain->nama_gunung }}">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $mountain->nama_gunung }}</div>
                                    <div class="flex items-center mt-1 text-xs text-gray-500">
                                        <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        {{ $mountain->reviews_count ?? 0 }} ulasan
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 truncate max-w-[150px]" title="{{ $mountain->lokasi }}">
                                {{ $mountain->lokasi }}
                            </div>
                            <div class="text-xs font-mono font-medium text-emerald-600 mt-1 bg-emerald-50 inline-block px-1.5 py-0.5 rounded">
                                {{ number_format($mountain->ketinggian) }} mdpl
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full border
                                {{ $mountain->tingkat_kesulitan === 'mudah' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                {{ $mountain->tingkat_kesulitan === 'sedang' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}
                                {{ $mountain->tingkat_kesulitan === 'sulit' ? 'bg-orange-50 text-orange-700 border-orange-200' : '' }}
                                {{ $mountain->tingkat_kesulitan === 'sangat sulit' ? 'bg-red-50 text-red-700 border-red-200' : '' }}">
                                {{ ucfirst($mountain->tingkat_kesulitan) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                <span class="flex items-center text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                    {{ $mountain->hiking_routes_count }} Jalur
                                </span>
                                <span class="flex items-center text-xs text-gray-600">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    {{ $mountain->packages_count }} Paket
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <button wire:click="toggleStatus({{ $mountain->id }})"
                                        wire:confirm="Ubah status aktif gunung ini?"
                                        class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 {{ $mountain->is_active ? 'bg-emerald-500' : 'bg-gray-200' }}"
                                        role="switch">
                                    <span aria-hidden="true" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $mountain->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                                </button>
                                <span class="text-xs font-medium {{ $mountain->is_active ? 'text-emerald-700' : 'text-gray-500' }}">
                                    {{ $mountain->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('mountains.show', $mountain) }}" target="_blank" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Lihat di Web">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                <a href="{{ route('admin.mountains.edit', $mountain) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button wire:click="deleteMountain({{ $mountain->id }})" 
                                        wire:confirm="Yakin ingin menghapus gunung ini? Data jalur pendakian dan paket juga akan terhapus!" 
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus Permanen">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Belum ada data gunung</h3>
                                <p class="text-gray-500 mt-1 mb-6 max-w-sm">Data gunung yang Anda cari tidak ditemukan atau database masih kosong.</p>
                                <a href="{{ route('admin.mountains.create') }}" class="inline-flex items-center text-emerald-600 font-semibold hover:text-emerald-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Data Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mountains->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $mountains->links() }}
        </div>
        @endif
    </div>
</div>