<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Petualangan</h1>
                <p class="mt-2 text-sm text-gray-500">Kelola dan pantau semua perjalanan gunung Anda di sini.</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-3">
                <div class="px-4 py-2 bg-white rounded-lg shadow-sm border border-gray-100">
                    <span class="text-xs text-gray-400 uppercase font-semibold">Total Booking</span>
                    <p class="text-lg font-bold text-gray-800">{{ $bookings->total() }}</p>
                </div>
            </div>
        </div>

        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-100 shadow-sm" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div><span class="font-medium">Berhasil!</span> {{ session('success') }}</div>
                <button @click="show = false" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8"><span class="sr-only">Close</span><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-100 shadow-sm" role="alert">
                <span class="font-medium">Error!</span> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <div class="md:col-span-8 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="searchTerm"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                        placeholder="Cari kode booking, nama paket, atau alat..."
                    >
                </div>

                <div class="md:col-span-4">
                    <select 
                        wire:model.live="statusFilter"
                        class="block w-full py-2.5 px-4 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    >
                        <option value="">Semua Status</option>
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @forelse($bookings as $booking)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-1.5 h-full 
                        @if($booking->status_booking == 'paid' || $booking->status_booking == 'completed') bg-green-500 
                        @elseif($booking->status_booking == 'cancelled') bg-red-500 
                        @else bg-yellow-500 @endif">
                    </div>

                    <div class="p-6 pl-8"> <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6">
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border
                                        {{ $booking->status_booking == 'paid' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                        {{ $booking->status_booking == 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}
                                        {{ $booking->status_booking == 'cancelled' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                    ">
                                        {{ $statuses[$booking->status_booking] }}
                                    </span>
                                </div>
                                <h3>
                                {{ $booking->package?->nama_paket ?? 'Open trip islamicadvanture' }}
                            </h3>
                            </div>

                            <div class="mt-4 lg:mt-0 text-right">
                                <p class="text-xs text-gray-500 mb-1">Total Biaya</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="h-px bg-gray-100 w-full mb-4"></div>

                        <div class="flex flex-col md:flex-row gap-6 text-sm">
                            <div class="flex-1">
                                <p class="text-gray-500 mb-2">Jadwal Perjalanan</p>
                                <div class="flex items-center text-gray-800 font-medium bg-gray-50 px-3 py-2 rounded-lg w-fit">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    @php
                                    $mulai = \Carbon\Carbon::parse($booking->tanggal_mulai);
                                    $selesai = \Carbon\Carbon::parse($booking->tanggal_selesai);

                                    if ($selesai->lt($mulai->copy()->addDays(2))) {
                                        $selesai = $mulai->copy()->addDays(2);
                                    }
                                @endphp
                                {{ $mulai->format('d M') }} - {{ $selesai->format('d M Y') }}
                                </div>
                            </div>
                            
                            @if($booking->items->count() > 0)
                            <div class="flex-1">
                                <p class="text-gray-500 mb-2">Paket trip dan Equipment</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($booking->items->take(3) as $item)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-medium">
                                            {{ $item->item_name }} ({{ $item->quantity }})
                                        </span>
                                    @endforeach
                                    @if($booking->items->count() > 3)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 text-xs font-medium">
                                            +{{ $booking->items->count() - 3 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                       <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap gap-3 justify-end">
                            @if($booking->payment && $booking->payment->status_pembayaran === 'paid')
                                <button wire:click="downloadInvoice({{ $booking->id }})" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Invoice
                                </button>
                            @endif

                            {{-- ✅ TAMBAHKAN TOMBOL REVIEW DI SINI --}}
                            @if($booking->status_booking === 'completed')
                                @php
                                    $hasReview = \App\Models\Review::where('booking_id', $booking->id)
                                        ->where('user_id', auth()->id())
                                        ->exists();
                                @endphp
                                
                                @if($hasReview)
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded-lg">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Sudah Direview
                                    </span>
                                @else
                                    <a href="{{ route('reviews.create', $booking->id) }}" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-500 border border-transparent rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                        Tulis Review
                                    </a>
                                @endif
                            @endif

                            @if(in_array($booking->status_booking, ['pending', 'confirmed']))
                                <button wire:click="openCancelModal({{ $booking->id }})" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-transparent rounded-lg hover:bg-red-100 focus:outline-none transition-colors">
                                    Batalkan
                                </button>
                            @endif

                            <button wire:click="viewDetail({{ $booking->id }})" class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-300">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat booking</h3>
                    <p class="mt-1 text-gray-500 max-w-sm mx-auto">
                        @if($searchTerm || $statusFilter)
                            Tidak ada hasil yang cocok dengan filter pencarian Anda. Coba reset filter.
                        @else
                            Anda belum melakukan pemesanan apapun. Mulai petualangan Anda sekarang!
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    </div>

    @if($showDetailModal && $selectedBooking)
        <div class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closeDetailModal"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                        <div class="pointer-events-auto w-screen max-w-2xl transform transition ease-in-out duration-500 sm:duration-700 translate-x-0" wire:click.stop>
                            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl">
                                <div class="px-4 py-6 sm:px-6 bg-indigo-600 text-white">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h2 class="text-xl font-semibold leading-6" id="slide-over-title">Detail Booking</h2>
                                            <p class="text-indigo-100 text-sm mt-1">Kode: {{ $selectedBooking->kode_booking }}</p>
                                        </div>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button wire:click="closeDetailModal" class="relative rounded-md text-indigo-200 hover:text-white focus:outline-none">
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative flex-1 px-4 py-6 sm:px-6 space-y-8">
                                    
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                        <div class="text-sm text-gray-500">Status Pesanan</div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $this->getStatusBadgeClass($selectedBooking->status_booking) }}">
                                            {{ $statuses[$selectedBooking->status_booking] }}
                                        </span>
                                    </div>

                                    @if($selectedBooking->package)
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Informasi Paket</h3>
                                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                                <div class="p-4 bg-indigo-50 border-b border-indigo-100 flex items-center">
                                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <span class="font-bold text-gray-900">{{ $selectedBooking->package->nama_paket }}</span>
                                                </div>
                                                <div class="p-4 grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <p class="text-gray-500">Destinasi</p>
                                                        <p class="font-medium">{{ $selectedBooking->package->mountain->nama_gunung }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-500">Durasi</p>
                                                        <p class="font-medium">{{ $selectedBooking->package->durasi_hari }} Hari</p>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <p class="text-gray-500">Tanggal</p>
                                                        <p class="font-medium">
                                                            {{ \Carbon\Carbon::parse($selectedBooking->tanggal_mulai)->format('d M Y') }} - 
                                                            {{ \Carbon\Carbon::parse($selectedBooking->tanggal_selesai)->format('d M Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($selectedBooking->items->count() > 0)
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Peralatan Sewa</h3>
                                            <ul class="divide-y divide-gray-100 bg-white border border-gray-200 rounded-xl overflow-hidden">
                                                @foreach($selectedBooking->items as $item)
                                                    <li class="p-4 flex items-center hover:bg-gray-50 transition-colors">
                                                        @if($item->item_image)
                                                            <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                                <img src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}" class="h-full w-full object-cover object-center">
                                                            </div>
                                                        @else
                                                            <div class="h-12 w-12 flex-shrink-0 bg-gray-100 rounded-md flex items-center justify-center text-gray-400">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                            </div>
                                                        @endif
                                                        <div class="ml-4 flex-1 flex flex-col">
                                                            <div>
                                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3>{{ $item->item_name }}</h3>
                                                                    <p class="ml-4">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                                </div>
                                                                <p class="mt-1 text-sm text-gray-500">{{ $item->quantity }} Unit x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="border-t border-gray-100 pt-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="text-base font-medium text-gray-900">Total Pembayaran</span>
                                            <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($selectedBooking->total_biaya, 0, ',', '.') }}</span>
                                        </div>

                                        @if($selectedBooking->payment)
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Metode</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ ucfirst($selectedBooking->payment->metode_pembayaran) }}</dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Status Bayar</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                            {{ ucfirst($selectedBooking->payment->status_pembayaran) }}
                                                        </span>
                                                    </dd>
                                                </div>
                                            </dl>
                                        @endif
                                    </div>
                                    
                                    @if($selectedBooking->catatan)
                                        <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4">
                                            <h4 class="text-sm font-semibold text-yellow-800 mb-1">Catatan Tambahan</h4>
                                            <p class="text-sm text-yellow-700">{{ $selectedBooking->catatan }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showCancelModal && $selectedBooking)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closeCancelModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full" @click.stop>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Konfirmasi Pembatalan</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Anda akan membatalkan booking <strong>{{ $selectedBooking->kode_booking }}</strong>. Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                    
                                    <label class="block text-sm font-medium text-gray-700 mb-2 text-left">Alasan Pembatalan</label>
                                    <textarea 
                                        wire:model="cancelReason" 
                                        rows="3" 
                                        class="w-full shadow-sm focus:ring-red-500 focus:border-red-500 block sm:text-sm border-gray-300 rounded-lg p-2"
                                        placeholder="Tulis alasan singkat..."
                                    ></textarea>
                                    @error('cancelReason') <span class="text-red-500 text-xs mt-1 block text-left">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="cancelBooking" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Ya, Batalkan
                        </button>
                        <button type="button" wire:click="closeCancelModal" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>