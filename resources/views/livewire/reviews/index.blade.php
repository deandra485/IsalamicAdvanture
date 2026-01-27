<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tulis Ulasan</h1>
            <p class="text-gray-500 mt-2 text-lg">Bagikan pengalaman perjalanan Anda untuk membantu orang lain.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100">
                {{ $bookings->count() }} Menunggu Review
            </span>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($bookings as $booking)
            <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 uppercase tracking-wide">
                                {{ $booking->booking_type }}
                            </span>
                            <span class="text-xs text-gray-400 font-mono">#{{ $booking->id }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">
                            Paket Trip
                        </h3>

                        <div class="flex items-center text-gray-500 text-sm mt-3">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>
                                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} 
                                <span class="mx-2 text-gray-300">&mdash;</span> 
                                {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        <a href="{{ route('reviews.create', $booking->id) }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Tulis Review
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Semuanya Beres!</h3>
                <p class="text-gray-500 max-w-sm mx-auto mb-8">
                    Tidak ada booking yang menunggu ulasan saat ini. Anda dapat melihat riwayat perjalanan Anda sebelumnya.
                </p>
                <a href="{{ route('user.bookings.history') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Lihat Riwayat Booking
                </a>
            </div>
        @endforelse
    </div>
</div>