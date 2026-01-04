<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
        <p class="text-gray-600 mt-1">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Bookings -->
        <div class="card">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Booking</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_bookings'] }}</p>
                </div>
            </div>
            @if($stats['pending_bookings'] > 0)
            <div class="mt-3 text-sm text-orange-600">
                {{ $stats['pending_bookings'] }} menunggu konfirmasi
            </div>
            @endif
        </div>

        <!-- Total Equipment -->
        <div class="card">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Peralatan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_equipment'] }}</p>
                </div>
            </div>
            <div class="mt-3 text-sm text-green-600">
                {{ $stats['available_equipment'] }} tersedia
            </div>
        </div>

        <!-- Total Customers -->
        <div class="card">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_customers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="card">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @if($stats['pending_payments'] > 0)
            <div class="mt-3 text-sm text-orange-600">
                {{ $stats['pending_payments'] }} pembayaran menunggu verifikasi
            </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Bookings -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Booking Terbaru</h2>
                <a href="{{ route('admin.bookings.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-4">
                @forelse($recentBookings as $booking)
                <div class="border-b pb-4 last:border-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $booking->items->count() }} item • 
                                {{ $booking->durasi_hari }} hari
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $booking->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 text-xs rounded-full
                                {{ $booking->status_booking === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $booking->status_booking === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $booking->status_booking === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status_booking === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($booking->status_booking) }}
                            </span>
                            <p class="text-sm font-bold text-gray-900 mt-2">
                                Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-4">Belum ada booking</p>
                @endforelse
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Pembayaran Perlu Verifikasi</h2>
                <a href="{{ route('admin.payments.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                    Lihat Semua
                </a>
            </div>

            <div class="space-y-4">
                @forelse($pendingPayments as $payment)
                <div class="border-b pb-4 last:border-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">
                                {{ $payment->booking->user->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                Booking #{{ $payment->booking->id }} • 
                                {{ ucfirst($payment->metode_pembayaran) }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $payment->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('admin.payments.index') }}" 
                               class="text-xs text-primary-600 hover:text-primary-700 mt-2 inline-block">
                                Verifikasi
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-4">Tidak ada pembayaran yang perlu diverifikasi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>


