<div class="min-h-screen bg-gray-50 py-10">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Riwayat Perjalanan</h1>
                <p class="text-gray-500 mt-1 text-sm">Kelola semua petualangan mendaki Anda di satu tempat.</p>
            </div>
            
            @if($bookings->count() > 0)
                <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                    <div class="text-center px-2">
                        <span class="block text-xs text-gray-400 uppercase font-semibold">Total</span>
                        <span class="font-bold text-gray-800">{{ $bookings->total() }}</span>
                    </div>
                    <div class="w-px h-8 bg-gray-200"></div>
                    <div class="text-center px-2">
                        <span class="block text-xs text-gray-400 uppercase font-semibold">Sukses</span>
                        <span class="font-bold text-green-600">{{ $statusCounts['completed'] ?? 0 }}</span>
                    </div>
                </div>
            @endif
        </div>

        @if (session()->has('success') || session()->has('error'))
            <div class="fixed top-5 right-5 z-50 animate-bounce-in">
                @if (session()->has('success'))
                    <div class="bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="ml-2 hover:text-green-100"><svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="ml-2 hover:text-red-100"><svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                    </div>
                @endif
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-8">
            <div class="flex flex-col lg:flex-row gap-6 justify-between items-center">
                
                <div class="w-full lg:w-auto overflow-x-auto pb-2 lg:pb-0 hide-scrollbar">
                    <div class="inline-flex bg-gray-100 p-1.5 rounded-xl whitespace-nowrap">
                        @foreach(['' => 'Semua', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'completed' => 'Selesai', 'cancelled' => 'Batal'] as $key => $label)
                            <button 
                                wire:click="$set('statusFilter', '{{ $key }}')"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                                {{ $statusFilter === $key 
                                    ? 'bg-white text-blue-600 shadow-sm ring-1 ring-black/5' 
                                    : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50' }}"
                            >
                                {{ $label }}
                                @if(isset($statusCounts) && ($key === '' ? $statusCounts->sum() : ($statusCounts[$key] ?? 0)) > 0)
                                    <span class="ml-1 text-xs opacity-70 bg-gray-100 px-1.5 py-0.5 rounded-full {{ $statusFilter === $key ? 'bg-blue-50 text-blue-600' : '' }}">
                                        {{ $key === '' ? $statusCounts->sum() : ($statusCounts[$key] ?? 0) }}
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <div class="relative group w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all sm:text-sm"
                            placeholder="Cari kode booking..."
                        >
                    </div>

                    <select 
                        wire:model.live="sortBy"
                        class="block w-full sm:w-40 pl-3 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 sm:text-sm rounded-xl bg-gray-50 hover:bg-white transition-colors cursor-pointer"
                    >
                        <option value="created_at">Terbaru</option>
                        <option value="start_date">Tgl. Mendaki</option>
                        <option value="total_price">Harga</option>
                    </select>
                </div>
            </div>

            @if($search || $statusFilter)
                <div class="mt-4 flex justify-end">
                    <button wire:click="clearFilters" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Reset Filter
                    </button>
                </div>
            @endif
        </div>

        @if($bookings->count() > 0)
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden relative">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 
                            @if($booking->status_booking === 'pending') bg-yellow-400
                            @elseif($booking->status_booking === 'confirmed') bg-blue-500
                            @elseif($booking->status_booking === 'completed') bg-green-500
                            @elseif($booking->status_booking === 'cancelled') bg-red-500
                            @endif">
                        </div>

                        <div class="p-6 pl-8"> <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-6 border-b border-dashed border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center 
                                        @if($booking->status_booking === 'completed') bg-green-50 text-green-600
                                        @elseif($booking->status_booking === 'cancelled') bg-red-50 text-red-600
                                        @else bg-blue-50 text-blue-600 @endif">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ $booking->booking_code }}</h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                                @if($booking->status_booking === 'pending') bg-yellow-50 text-yellow-700 border-yellow-100
                                                @elseif($booking->status_booking === 'confirmed') bg-blue-50 text-blue-700 border-blue-100
                                                @elseif($booking->status_booking === 'completed') bg-green-50 text-green-700 border-green-100
                                                @elseif($booking->status_booking === 'cancelled') bg-red-50 text-red-700 border-red-100
                                                @endif">
                                                {{ ucfirst($booking->status_booking) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">Dipesan pada {{ $booking->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 md:mt-0 text-right">
                                    <span class="block text-xs text-gray-400 uppercase font-semibold mb-1">Total Biaya</span>
                                    <div class="text-2xl font-bold text-gray-900">
                                        Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                <div class="md:col-span-5 space-y-4">
                                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Detail Perjalanan</h4>
                                    
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1 p-1.5 bg-gray-100 rounded-lg text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $booking->package?->mountain?->name ?? 'Gunung Tidak Diketahui' }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->package?->name ?? 'Paket Kustom' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div class="p-1.5 bg-gray-100 rounded-lg text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="text-sm text-gray-700"><span class="font-medium">{{ $booking->number_of_people }}</span> Pendaki</p>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <div class="p-1.5 bg-gray-100 rounded-lg text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="text-sm text-gray-700">Durasi <span class="font-medium">{{ $booking->package?->duration_days ?? '-' }} Hari</span></p>
                                    </div>
                                </div>

                                <div class="md:col-span-3 space-y-4">
                                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jadwal</h4>
                                    <div class="relative pl-4 border-l-2 border-gray-100 space-y-6">
                                        <div class="relative">
                                            <div class="absolute -left-[21px] top-1 w-3 h-3 bg-blue-500 rounded-full ring-4 ring-white"></div>
                                            <p class="text-xs text-gray-500 mb-0.5">Berangkat</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $booking->tanggal_mulai?->format('d M Y') }}</p>
                                        </div>
                                        <div class="relative">
                                            <div class="absolute -left-[21px] top-1 w-3 h-3 bg-gray-300 rounded-full ring-4 ring-white"></div>
                                            <p class="text-xs text-gray-500 mb-0.5">Selesai</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $booking->tanggal_selesai?->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-4 flex flex-col justify-between h-full">
                                    
                                    <div class="mb-4">
                                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Tambahan</h4>
                                        @if($booking->items->isNotEmpty())
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($booking->items->take(3) as $item)
                                                    <span class="inline-flex items-center px-2 py-1 bg-gray-50 text-gray-600 text-xs rounded-md border border-gray-100">
                                                        {{ $item->equipment->name }} <span class="ml-1 text-gray-400">x{{ $item->quantity }}</span>
                                                    </span>
                                                @endforeach
                                                @if($booking->items->count() > 3)
                                                    <span class="inline-flex items-center px-2 py-1 bg-gray-50 text-gray-500 text-xs rounded-md border border-gray-100">
                                                        +{{ $booking->items->count() - 3 }} lainnya
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-400 italic">Tidak ada sewa peralatan.</p>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 gap-2 mt-auto">
                                        <a href="{{ route('user.bookings.show', $booking->id) }}" class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all text-sm font-medium shadow-sm">
                                            Lihat Detail Lengkap
                                        </a>

                                        @if(in_array($booking->status, ['confirmed', 'completed']))
                                            <button wire:click="downloadInvoice({{ $booking->id }})" class="flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm font-medium shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Download Invoice
                                            </button>
                                        @endif

                                        @if(in_array($booking->status, ['pending', 'confirmed']))
                                            <button wire:click="openCancelModal({{ $booking->id }})" class="flex items-center justify-center w-full px-4 py-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors text-sm font-medium">
                                                Batalkan Booking
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($booking->status === 'cancelled' && $booking->cancel_reason)
                                <div class="mt-6 flex items-start p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-100" role="alert">
                                    <svg class="flex-shrink-0 inline w-5 h-5 me-3 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div>
                                        <span class="font-bold block mb-1">Dibatalkan karena:</span>
                                        {{ $booking->cancel_reason }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $bookings->links() }} 
                </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Petualangan</h3>
                <p class="text-gray-500 mb-8 text-center max-w-sm">Anda belum memiliki riwayat booking. Mulailah petualangan pertama Anda menuju puncak gunung!</p>
                <a href="{{ route('packages.index') }}" class="px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/30 font-semibold transform hover:-translate-y-0.5">
                    Cari Paket Pendakian
                </a>
            </div>
        @endif
    </div>

    @if($showCancelModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div 
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                    aria-hidden="true"
                    wire:click="closeCancelModal">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    Batalkan Booking {{ $bookingToCancel->booking_code }}?
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Tindakan ini tidak dapat dibatalkan. Mohon berikan alasan pembatalan Anda.
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Alasan Pembatalan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        wire:model="cancelReason"
                                        rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm placeholder-gray-400"
                                        placeholder="Contoh: Perubahan jadwal mendadak..."
                                    ></textarea>
                                    @error('cancelReason')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mt-4 bg-orange-50 p-3 rounded-lg border border-orange-100">
                                    <p class="text-xs text-orange-800 flex gap-2">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                                        Stok peralatan akan dikembalikan ke inventaris. Uang muka yang sudah masuk mungkin tidak dapat dikembalikan sesuai kebijakan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button 
                            wire:click="cancelBooking"
                            type="button" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                        >
                            Konfirmasi Pembatalan
                        </button>
                        <button 
                            wire:click="closeCancelModal"
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors"
                        >
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>