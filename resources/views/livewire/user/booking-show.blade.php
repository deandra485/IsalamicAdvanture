<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <a href="{{ route('user.bookings.history') }}" 
               class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors mb-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Riwayat
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Booking</h1>
            <p class="text-gray-500 text-sm mt-1">Kode Referensi: <span class="font-mono text-gray-700 bg-gray-100 px-2 py-0.5 rounded">{{ $booking->booking_code }}</span></p>
        </div>

        @php
            $statusStyles = match($booking->status_booking) {
                'pending'   => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-500/20',
                'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-500/20',
                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-500/20',
                'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-500/20',
                default     => 'bg-gray-50 text-gray-700 border-gray-200 ring-gray-500/20',
            };
            
            $statusIcon = match($booking->status_booking) {
                'pending'   => 'Wait',
                'confirmed' => 'Check',
                'completed' => 'Star',
                'cancelled' => 'X',
                default     => 'Question',
            };
        @endphp

        <div class="flex items-center">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border ring-1 ring-inset {{ $statusStyles }}">
                <span class="w-2 h-2 rounded-full bg-current mr-2 animate-pulse"></span>
                {{ ucfirst($booking->status_booking) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Informasi Paket
                    </h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Destinasi Gunung</p>
                        <p class="text-lg font-medium text-gray-900">{{ $booking->package?->mountain?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Paket</p>
                        <p class="text-lg font-medium text-gray-900">{{ $booking->package?->name ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2 grid grid-cols-2 gap-4 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                        <div>
                            <p class="text-xs text-blue-600 font-medium mb-1">Check-In</p>
                            <p class="font-semibold text-gray-900">{{ $booking->tanggal_mulai?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-blue-600 font-medium mb-1">Check-Out</p>
                            <p class="font-semibold text-gray-900">{{ $booking->tanggal_selesai?->format('d M Y') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Peralatan Tambahan
                    </h2>
                </div>
                <div class="p-6">
                    @if($booking->items->isNotEmpty())
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($booking->items as $item)
                                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200 bg-gray-50 hover:border-gray-300 transition-colors">
                                    <span class="text-sm font-medium text-gray-700 truncate mr-2">{{ $item->equipment->name }}</span>
                                    <span class="text-xs font-bold text-white bg-gray-500 px-2 py-0.5 rounded-full">x{{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-400 italic text-sm">Tidak menyewa peralatan tambahan.</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($booking->status_booking === 'cancelled' && $booking->cancel_reason)
                <div class="rounded-2xl bg-red-50 border border-red-100 p-6 flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Booking Dibatalkan</h3>
                        <p class="mt-1 text-sm text-red-700 leading-relaxed">{{ $booking->cancel_reason }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-6">
                <div class="p-6 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
                    <p class="text-gray-300 text-sm mb-1">Total Pembayaran</p>
                    <div class="text-3xl font-bold tracking-tight">
                        Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 text-sm">Durasi</span>
                        <span class="font-semibold text-gray-900">{{ $booking->durasi_hari ?? '-' }} Hari</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 text-sm">Peserta</span>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="font-semibold text-gray-900">{{ $booking->number_of_people }} Orang</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 space-y-3">
                    @if(in_array($booking->status_booking, ['confirmed', 'completed']))
                        <button wire:click="downloadInvoice({{ $booking->id }})" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 active:scale-[0.98] transition-all font-semibold shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Invoice
                        </button>
                    @endif

                    @if(in_array($booking->status_booking, ['pending', 'confirmed']))
                        <button wire:click="openCancelModal({{ $booking->id }})" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white text-rose-600 border border-rose-200 rounded-xl hover:bg-rose-50 hover:border-rose-300 active:scale-[0.98] transition-all font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batalkan Booking
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>