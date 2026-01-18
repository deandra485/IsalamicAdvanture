<div class="min-h-screen bg-gray-50/50 p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Admin</h1>
            <p class="text-gray-500 mt-2 text-sm">
                Selamat datang kembali, <span class="font-semibold text-indigo-600">{{ auth()->user()->name }}</span>! Berikut ringkasan hari ini.
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium text-gray-600 shadow-sm">
                <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ now()->format('d F Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Booking</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_bookings'] }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            @if($stats['pending_bookings'] > 0)
                <div class="mt-4 flex items-center text-xs font-medium text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full w-fit">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                    {{ $stats['pending_bookings'] }} menunggu konfirmasi
                </div>
            @else
                <div class="mt-4 text-xs text-gray-400">Semua booking terproses</div>
            @endif
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Peralatan</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_equipment'] }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full w-fit">
                {{ $stats['available_equipment'] }} unit tersedia
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pelanggan</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_customers'] }}</h3>
                </div>
                <div class="p-3 bg-violet-50 rounded-xl">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400">Data pelanggan aktif</div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Pendapatan Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900 truncate">
                        Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-3 bg-amber-50 rounded-xl">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            @if($stats['pending_payments'] > 0)
                <div class="mt-4 flex items-center text-xs font-medium text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full w-fit">
                    {{ $stats['pending_payments'] }} perlu verifikasi
                </div>
            @else
                <div class="mt-4 text-xs text-gray-400">Keuangan aman</div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Booking Terbaru</h2>
                <a href="{{ route('admin.bookings.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline transition-colors">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse($recentBookings as $booking)
                <div class="p-5 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-sm">
                                {{ substr($booking->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $booking->items->count() }} item • {{ $booking->durasi_hari }} hari
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                {{ $booking->status_booking === 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $booking->status_booking === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $booking->status_booking === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $booking->status_booking === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $booking->status_booking }}
                            </span>
                            <p class="text-sm font-bold text-gray-900 mt-1">
                                Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm">Belum ada data booking terbaru.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Verifikasi Pembayaran</h2>
                <a href="{{ route('admin.payments.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline transition-colors">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse($pendingPayments as $payment)
                <div class="p-5 hover:bg-gray-50 transition-colors duration-200 group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="h-10 w-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $payment->booking->user->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    ID #{{ $payment->booking->id }} • {{ ucfirst($payment->metode_pembayaran) }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('admin.payments.index') }}" 
                               class="inline-block mt-1 text-xs font-semibold text-indigo-600 group-hover:text-indigo-800">
                                Verifikasi Sekarang &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-50 mb-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm">Semua pembayaran telah diverifikasi.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>