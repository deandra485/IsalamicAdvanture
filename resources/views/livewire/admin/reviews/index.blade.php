<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Review</h1>
        <p class="text-gray-600 mt-1">Kelola review dari pelanggan</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Total Review</div>
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Disetujui</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Menunggu</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Rating Rata-rata</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['avg_rating'] }}/5</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" wire:model.live.debounce.300ms="search" 
                    placeholder="Cari review, user, atau gunung..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="filterStatus" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="all">Semua Status</option>
                    <option value="approved">Disetujui</option>
                    <option value="pending">Menunggu</option>
                </select>
            </div>

            <!-- Filter Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <select wire:model.live="filterRating" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="all">Semua Rating</option>
                    <option value="5">⭐ 5 Bintang</option>
                    <option value="4">⭐ 4 Bintang</option>
                    <option value="3">⭐ 3 Bintang</option>
                    <option value="2">⭐ 2 Bintang</option>
                    <option value="1">⭐ 1 Bintang</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gunung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $review->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $review->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $review->mountain->nama }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600">({{ $review->rating }})</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    {{ $review->komentar ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($review->is_approved)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $review->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button wire:click="viewDetail({{ $review->id }})" 
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                    Detail
                                </button>
                                @if(!$review->is_approved)
                                    <button wire:click="approveReview({{ $review->id }})" 
                                        class="text-green-600 hover:text-green-900 mr-3">
                                        Setujui
                                    </button>
                                @else
                                    <button wire:click="rejectReview({{ $review->id }})" 
                                        class="text-yellow-600 hover:text-yellow-900 mr-3">
                                        Tolak
                                    </button>
                                @endif
                                <button wire:click="confirmDelete({{ $review->id }})" 
                                    class="text-red-600 hover:text-red-900">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada review ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedReview)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Detail Review</h3>
                    <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- User Info -->
                    <div class="border-b pb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama User</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedReview->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedReview->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Mountain & Booking Info -->
                    <div class="border-b pb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gunung</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedReview->mountain->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Booking ID</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $selectedReview->booking_id ? '#' . $selectedReview->booking_id : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="border-b pb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-2xl {{ $i <= $selectedReview->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                            @endfor
                            <span class="ml-3 text-lg text-gray-600">({{ $selectedReview->rating }}/5)</span>
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="border-b pb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                        <p class="text-sm text-gray-900">{{ $selectedReview->komentar ?? 'Tidak ada komentar' }}</p>
                    </div>

                    <!-- Photos -->
                    @if(!empty($selectedReview->photo_urls))
                        <div class="border-b pb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($selectedReview->photo_urls as $photo)
                                    <img src="{{ $photo }}" alt="Review Photo" class="w-full h-32 object-cover rounded">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Status & Approval -->
                    <div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1">
                                    @if($selectedReview->is_approved)
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu Persetujuan
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Disetujui Oleh</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $selectedReview->approvedBy?->name ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-500">
                        <div>
                            <label class="block font-medium">Dibuat:</label>
                            <p>{{ $selectedReview->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block font-medium">Diupdate:</label>
                            <p>{{ $selectedReview->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex justify-end space-x-3">
                    @if(!$selectedReview->is_approved)
                        <button wire:click="approveReview({{ $selectedReview->id }})" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Setujui Review
                        </button>
                    @else
                        <button wire:click="rejectReview({{ $selectedReview->id }})" 
                            class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                            Tolak Review
                        </button>
                    @endif
                    <button wire:click="confirmDelete({{ $selectedReview->id }})" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus Review
                    </button>
                    <button wire:click="closeDetailModal" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus review ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="cancelDelete" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <button wire:click="deleteReview" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>