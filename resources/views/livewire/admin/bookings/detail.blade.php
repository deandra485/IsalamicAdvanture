<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.bookings.index') }}" class="hover:text-primary-600">Bookings</a>
            <span>/</span>
            <span class="text-gray-900">#{{ $booking->id }}</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Booking #{{ $booking->id }}</h1>
                <p class="text-gray-600 mt-1">{{ $booking->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="btn-secondary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Invoice
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Info -->
            <div class="card">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Customer</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Nama</label>
                        <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="font-semibold text-gray-900">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">No. Telepon</label>
                        <p class="font-semibold text-gray-900">{{ $booking->user->no_telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Metode Pengambilan</label>
                        <p class="font-semibold text-gray-900">{{ ucfirst($booking->metode_pengambilan) }}</p>
                    </div>
                    @if($booking->alamat_pengiriman)
                    <div class="col-span-2">
                        <label class="text-sm text-gray-600">Alamat Pengiriman</label>
                        <p class="font-semibold text-gray-900">{{ $booking->alamat_pengiriman }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Booking Details -->
            <div class="card">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Detail Booking</h2>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-600">Tanggal Mulai</label>
                        <p class="font-semibold text-gray-900">{{ $booking->tanggal_mulai->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Tanggal Selesai</label>
                        <p class="font-semibold text-gray-900">{{ $booking->tanggal_selesai->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Durasi</label>
                        <p class="font-semibold text-gray-900">{{ $booking->durasi_hari }} hari</p>
                    </div>
                </div>

                <!-- Items -->
                <div class="border-t pt-4">
                    <h3 class="font-bold text-gray-900 mb-3">Item yang Disewa</h3>
                    <div class="space-y-3">
                        @foreach($booking->items as $item)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                @if($item->equipment->primaryImage)
                                <img src="{{ Storage::url($item->equipment->primaryImage->image_url) }}"
                                     class="w-16 h-16 rounded-lg object-cover">
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->equipment->nama_peralatan }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->equipment->category->nama_kategori }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $item->quantity }} x {{ $booking->durasi_hari }} hari x 
                                        Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-primary-600">Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="card">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Catatan</h2>
                
                @if($booking->catatan_customer)
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-700">Catatan Customer</label>
                    <p class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $booking->catatan_customer }}</p>
                </div>
                @endif

                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Catatan Admin</label>
                    <textarea wire:model="adminNotes"
                              rows="4"
                              class="input-field"
                              placeholder="Tambahkan catatan internal..."></textarea>
                    <button wire:click="saveNotes" class="mt-2 btn-primary">
                        Simpan Catatan
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Status Booking</h3>
                
                <div class="space-y-3">
                    <button wire:click="openStatusModal('pending')"
                            class="w-full p-3 text-left rounded-lg border-2 transition
                                {{ $booking->status_booking === 'pending' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <span class="font-semibold {{ $booking->status_booking === 'pending' ? 'text-orange-700' : 'text-gray-700' }}">
                            Pending
                        </span>
                    </button>

                    <button wire:click="openStatusModal('confirmed')"
                            class="w-full p-3 text-left rounded-lg border-2 transition
                                {{ $booking->status_booking === 'confirmed' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <span class="font-semibold {{ $booking->status_booking === 'confirmed' ? 'text-blue-700' : 'text-gray-700' }}">
                            Confirmed
                        </span>
                    </button>

                    <button wire:click="openStatusModal('ongoing')"
                            class="w-full p-3 text-left rounded-lg border-2 transition
                                {{ $booking->status_booking === 'ongoing' ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <span class="font-semibold {{ $booking->status_booking === 'ongoing' ? 'text-purple-700' : 'text-gray-700' }}">
                            Ongoing
                        </span>
                    </button>

                    <button wire:click="openStatusModal('completed')"
                            class="w-full p-3 text-left rounded-lg border-2 transition
                                {{ $booking->status_booking === 'completed' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <span class="font-semibold {{ $booking->status_booking === 'completed' ? 'text-green-700' : 'text-gray-700' }}">
                            Completed
                        </span>
                    </button>

                    <button wire:click="openStatusModal('cancelled')"
                            class="w-full p-3 text-left rounded-lg border-2 transition
                                {{ $booking->status_booking === 'cancelled' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <span class="font-semibold {{ $booking->status_booking === 'cancelled' ? 'text-red-700' : 'text-gray-700' }}">
                            Cancelled
                        </span>
                    </button>
                </div>

                @if($booking->confirmedBy)
                <div class="mt-4 pt-4 border-t text-xs text-gray-600">
                    Dikonfirmasi oleh {{ $booking->confirmedBy->name }}
                </div>
                @endif
            </div>

            <!-- Payment Status -->
            @if($booking->payment)
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Status Pembayaran</h3>
                
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-bold
                            {{ $booking->payment->status_pembayaran === 'pending' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $booking->payment->status_pembayaran === 'verified' ? 'bg-green-100 text-green-700' : '' }}">
                            {{ ucfirst($booking->payment->status_pembayaran) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode:</span>
                        <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $booking->payment->metode_pembayaran)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-bold">Rp {{ number_format($booking->payment->jumlah_bayar, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($booking->payment->bukti_pembayaran_url)
                <a href="{{ route('admin.payments.index') }}" 
                   class="mt-4 block btn-primary text-center">
                    Verifikasi Pembayaran
                </a>
                @endif
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <button onclick="window.print()" 
                            class="w-full btn-secondary text-sm">
                        Print Invoice
                    </button>
                    <a href="mailto:{{ $booking->user->email }}"
                       class="block w-full btn-secondary text-sm text-center">
                        Email Customer
                    </a>
                    @if($booking->user->no_telepon)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->user->no_telepon) }}"
                       target="_blank"
                       class="block w-full btn-secondary text-sm text-center">
                        WhatsApp Customer
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Status Modal -->
    @if($showStatusModal)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click="$set('showStatusModal', false)">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" wire:click.stop>
            <h3 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Perubahan Status</h3>
            <p class="text-gray-600 mb-6">
                Ubah status booking menjadi <strong class="text-gray-900">{{ ucfirst($newStatus) }}</strong>?
            </p>
            <div class="flex gap-3">
                <button wire:click="$set('showStatusModal', false)" 
                        class="flex-1 btn-secondary">
                    Batal
                </button>
                <button wire:click="updateStatus" 
                        class="flex-1 btn-primary">
                    Ya, Ubah Status
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
