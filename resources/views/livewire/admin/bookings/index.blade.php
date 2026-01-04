<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Booking</h1>
        <p class="text-gray-600 mt-1">Kelola semua booking pelanggan</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="card">
            <div class="text-xs text-gray-600 mb-1">Total</div>
            <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
        </div>
        <div class="card">
            <div class="text-xs text-gray-600 mb-1">Pending</div>
            <div class="text-2xl font-bold text-orange-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="card">
            <div class="text-xs text-gray-600 mb-1">Confirmed</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['confirmed'] }}</div>
        </div>
        <div class="card">
            <div class="text-xs text-gray-600 mb-1">Ongoing</div>
            <div class="text-2xl font-bold text-purple-600">{{ $stats['ongoing'] }}</div>
        </div>
        <div class="card">
            <div class="text-xs text-gray-600 mb-1">Completed</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
        </div>
        <div class="card">
            <div class="text-xs text-gray-600 mb-1">Cancelled</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" 
                       wire:model.live.debounce.500ms="search"
                       placeholder="Cari ID, nama, email..."
                       class="input-field">
            </div>

            <div>
                <select wire:model.live="statusFilter" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div>
                <input type="date" 
                       wire:model.live="dateFilter"
                       class="input-field">
            </div>

            <div>
                <select wire:model.live="sortBy" class="input-field">
                    <option value="created_at">Terbaru</option>
                    <option value="tanggal_mulai">Tanggal Mulai</option>
                    <option value="total_biaya">Total Biaya</option>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr wire:key="booking-{{ $booking->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900">#{{ $booking->id }}</span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking->tanggal_mulai->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->durasi_hari }} hari</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking->items->count() }} item</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($booking->payment)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $booking->payment->status_pembayaran === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $booking->payment->status_pembayaran === 'verified' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->payment->status_pembayaran === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($booking->payment->status_pembayaran) }}
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <select wire:change="updateStatus({{ $booking->id }}, $event.target.value)"
                                    class="text-xs rounded-full px-3 py-1 font-semibold border-0
                                        {{ $booking->status_booking === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $booking->status_booking === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $booking->status_booking === 'ongoing' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $booking->status_booking === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $booking->status_booking === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                <option value="pending" {{ $booking->status_booking === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status_booking === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="ongoing" {{ $booking->status_booking === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ $booking->status_booking === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status_booking === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.bookings.detail', $booking) }}"
                               class="text-primary-600 hover:text-primary-900 font-medium text-sm">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data booking
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>