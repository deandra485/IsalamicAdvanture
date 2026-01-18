<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('admin.bookings.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">Bookings</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-800">#{{ $booking->id }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Booking #{{ $booking->id }}</h1>
                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                    {{ $booking->status_booking === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $booking->status_booking === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $booking->status_booking === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $booking->status_booking === 'ongoing' ? 'bg-purple-100 text-purple-700' : '' }}
                    {{ $booking->status_booking === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ $booking->status_booking }}
                </span>
            </div>
            <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Dibuat pada {{ $booking->created_at->format('d F Y, H:i') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.pdf', ['date' => $booking->created_at->format('Y-m-d')]) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Invoice
            </a>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-500 shadow-sm flex items-center justify-between">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900">Informasi Pelanggan</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email Address</label>
                        <p class="mt-1 text-base font-medium text-gray-900 break-all">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nomor Telepon</label>
                        <p class="mt-1 text-base font-medium text-gray-900">{{ $booking->user->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Metode Pengambilan</label>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->metode_pengambilan == 'delivery' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($booking->metode_pengambilan) }}
                            </span>
                        </div>
                    </div>
                    @if($booking->alamat_pengiriman)
                    <div class="md:col-span-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Alamat Pengiriman</label>
                        <p class="mt-1 text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
                            {{ $booking->alamat_pengiriman }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900">Jadwal Sewa</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4 text-center divide-x divide-gray-100">
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Mulai Sewa</label>
                            <p class="text-lg font-bold text-gray-900">{{ $booking->tanggal_mulai?->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Selesai Sewa</label>
                            <p class="text-lg font-bold text-gray-900">{{ $booking->tanggal_selesai?->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Total Durasi</label>
                            <p class="text-lg font-bold text-indigo-600">{{ $booking->durasi_hari }} <span class="text-sm font-normal text-gray-500">Hari</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h2 class="text-lg font-bold text-gray-900">Rincian Barang</h2>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">{{ $booking->items->count() }} Items</span>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @foreach($booking->items as $item)
                    <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                        <div class="flex-shrink-0 w-16 h-16 rounded-lg bg-gray-100 overflow-hidden border border-gray-200">
                            @if($item->equipment?->primaryImage)
                                <img src="{{ Storage::url($item->equipment->primaryImage->image_url) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $item->item_name }}</h4>
                            <p class="text-xs text-gray-500 mb-1">{{ $item->equipment?->category?->nama_kategori }}</p>
                            <div class="flex items-center text-xs text-gray-500">
                                <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-700 font-medium">{{ $item->quantity }} unit</span>
                                <span class="mx-2 text-gray-300">|</span>
                                <span>x {{ $booking->durasi_hari }} hari</span>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">@ Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="px-6 py-5 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Total Tagihan</p>
                        <p class="text-xs text-gray-400">Termasuk pajak & biaya layanan</p>
                    </div>
                    <div class="text-2xl font-bold text-indigo-600">
                        Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <h2 class="text-lg font-bold text-gray-900">Catatan</h2>
                </div>
                <div class="p-6 space-y-6">
                    @if($booking->catatan_customer)
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            Pesan dari Customer
                        </label>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <p class="text-gray-800 text-sm italic">"{{ $booking->catatan_customer }}"</p>
                        </div>
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                            Catatan Internal Admin
                        </label>
                        <div class="relative">
                            <textarea wire:model="adminNotes" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3" placeholder="Tulis catatan internal di sini (hanya terlihat oleh admin)..."></textarea>
                            <div class="absolute bottom-2 right-2">
                                <button wire:click="saveNotes" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            @if($booking->payment)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Pembayaran
                    </h3>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $booking->payment->status_pembayaran === 'verified' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                            @if($booking->payment->status_pembayaran === 'verified')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            @else
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                            {{ ucfirst($booking->payment->status_pembayaran) }}
                        </span>
                    </div>
                    
                    <div class="space-y-3 pt-3 border-t border-gray-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Metode</span>
                            <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $booking->payment->metode_pembayaran)) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jumlah</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format($booking->payment->jumlah_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($booking->payment->bukti_pembayaran_url)
                    <div class="mt-6">
                        <a href="{{ route('admin.payments.show', $booking->payment->id) }}" class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                            Cek Bukti Transfer
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-bold text-gray-900">Update Status</h3>
                </div>
                <div class="p-4 space-y-2">
                    @php
                        $statuses = [
                            'pending' => ['label' => 'Pending', 'color' => 'orange', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'confirmed' => ['label' => 'Confirmed', 'color' => 'blue', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'ongoing' => ['label' => 'Ongoing', 'color' => 'purple', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            'completed' => ['label' => 'Completed', 'color' => 'green', 'icon' => 'M5 13l4 4L19 7'],
                            'cancelled' => ['label' => 'Cancelled', 'color' => 'red', 'icon' => 'M6 18L18 6M6 6l12 12'],
                        ];
                    @endphp

                    @foreach($statuses as $key => $status)
                        <button wire:click="openStatusModal('{{ $key }}')" 
                            class="w-full flex items-center justify-between p-3 rounded-lg border transition-all duration-200 group
                            {{ $booking->status_booking === $key 
                                ? 'bg-'.$status['color'].'-50 border-'.$status['color'].'-500 ring-1 ring-'.$status['color'].'-500' 
                                : 'bg-white border-gray-200 hover:border-'.$status['color'].'-300 hover:bg-gray-50' }}">
                            
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 rounded-full {{ $booking->status_booking === $key ? 'bg-'.$status['color'].'-200 text-'.$status['color'].'-700' : 'bg-gray-100 text-gray-500 group-hover:bg-'.$status['color'].'-100 group-hover:text-'.$status['color'].'-600' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"></path></svg>
                                </div>
                                <span class="text-sm font-medium {{ $booking->status_booking === $key ? 'text-'.$status['color'].'-800' : 'text-gray-700' }}">
                                    {{ $status['label'] }}
                                </span>
                            </div>
                            
                            @if($booking->status_booking === $key)
                                <svg class="w-5 h-5 text-{{ $status['color'] }}-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            @endif
                        </button>
                    @endforeach

                    @if($booking->confirmedBy)
                    <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                        <p class="text-xs text-gray-400">Terakhir diupdate oleh</p>
                        <p class="text-sm font-medium text-gray-600">{{ $booking->confirmedBy->name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Kontak Cepat</h3>
                </div>
                <div class="p-4 grid grid-cols-2 gap-3">
                    <a href="mailto:{{ $booking->user->email }}" class="flex flex-col items-center justify-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all group">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-xs font-medium text-gray-600 group-hover:text-indigo-700">Email</span>
                    </a>
                    @if($booking->user->no_telepon)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->user->no_telepon) }}" target="_blank" class="flex flex-col items-center justify-center p-3 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all group">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-green-600 mb-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        <span class="text-xs font-medium text-gray-600 group-hover:text-green-700">WhatsApp</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($showStatusModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" wire:click="$set('showStatusModal', false)">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full" wire:click.stop>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Konfirmasi Perubahan Status</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin mengubah status booking ini menjadi <span class="font-bold text-gray-800">{{ ucfirst($newStatus) }}</span>?
                                    @if($newStatus === 'cancelled')
                                        <br><span class="text-red-500 text-xs mt-1 block">*Stok barang akan dikembalikan jika status dibatalkan.</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="updateStatus" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Ya, Ubah Status
                    </button>
                    <button type="button" wire:click="$set('showStatusModal', false)" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>