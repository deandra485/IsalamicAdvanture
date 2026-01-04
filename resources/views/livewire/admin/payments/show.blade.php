<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header with Back Button -->
        <div class="mb-8">
            <a href="{{ route('admin.payments.index') }}" 
               class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Payment
            </a>
            
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Payment</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ $payment->booking->kode_booking }}</p>
                </div>
                
                <!-- Status Badge -->
                <div>
                    @if($payment->status_pembayaran === 'pending')
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Pending Verification
                        </span>
                    @elseif($payment->status_pembayaran === 'verified')
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Rejected
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Info Cards -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Customer Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Customer Information
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $payment->booking->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <p class="text-sm text-gray-900">{{ $payment->booking->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">No. Telepon</p>
                            <p class="text-sm text-gray-900">{{ $payment->booking->user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Terdaftar Sejak</p>
                            <p class="text-sm text-gray-900">{{ $payment->booking->user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Booking Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Booking Information
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Kode Booking</p>
                            <p class="text-sm font-mono font-semibold text-gray-900">{{ $payment->booking->kode_booking }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tipe Booking</p>
                            <p class="text-sm text-gray-900 capitalize">{{ $payment->booking->booking_type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Mulai</p>
                            <p class="text-sm text-gray-900">{{ $payment->booking->tanggal_mulai->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Selesai</p>
                            <p class="text-sm text-gray-900">{{ $payment->booking->tanggal_selesai->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Durasi</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $payment->booking->durasi_hari }} Hari</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Status Booking</p>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                {{ $payment->booking->status_booking }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Payment Information
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Jumlah Bayar</p>
                            <p class="text-xl font-bold text-green-600">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Metode Pembayaran</p>
                            <p class="text-sm text-gray-900 capitalize">{{ $payment->metode_pembayaran }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Pembayaran</p>
                            <p class="text-sm text-gray-900">{{ $payment->tanggal_pembayaran->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            @if($payment->status_pembayaran === 'pending')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($payment->status_pembayaran === 'verified')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Verified</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                @if($payment->booking->items->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Booking</h3>
                        <div class="space-y-3">
                            @foreach($payment->booking->items as $item)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $item->product->name ?? $item->product_name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $item->quantity }} x Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">Rp {{ number_format($item->harga_sewa * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <div class="flex justify-between items-center pt-4 border-t-2 border-gray-200">
                                <span class="text-base font-bold text-gray-900">Total Biaya</span>
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($payment->booking->total_biaya, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Actions & Proof -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Payment Proof -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bukti Pembayaran
                    </h3>
                    @if($payment->bukti_pembayaran_url)
                        <div class="space-y-3">
                            <div class="relative group overflow-hidden rounded-lg">
                                <img src="{{ Storage::url($payment->bukti_pembayaran_url) }}" 
                                     alt="Payment Proof" 
                                     class="w-full border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-400 transition">
                            </div>
                            <button wire:click="downloadProof" 
                                    class="w-full flex items-center justify-center px-4 py-2.5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-sm font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download Bukti
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Bukti pembayaran belum diupload</p>
                        </div>
                    @endif
                </div>

                <!-- Verification Actions (Pending Only) -->
                @if($payment->isPending())
                    <div class="bg-white rounded-xl shadow-sm border-2 border-blue-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Verifikasi</h3>
                        
                        <!-- Verify Section -->
                        <div class="mb-5">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Catatan Verifikasi (Opsional)</label>
                            <textarea wire:model="verificationNote" 
                                      rows="3" 
                                      placeholder="Tambahkan catatan jika diperlukan..."
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                            @error('verificationNote') 
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <button wire:click="verifyPayment" 
                                    wire:loading.attr="disabled"
                                    wire:target="verifyPayment"
                                    class="mt-3 w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition text-sm font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span wire:loading.remove wire:target="verifyPayment">Verifikasi Payment</span>
                                <span wire:loading wire:target="verifyPayment">Processing...</span>
                            </button>
                        </div>

                        <!-- Reject Section -->
                        <div class="border-t pt-5">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea wire:model="rejectReason" 
                                      rows="3" 
                                      placeholder="Jelaskan alasan penolakan (min. 10 karakter)..."
                                      class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-500 text-sm"></textarea>
                            @error('rejectReason') 
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <button wire:click="rejectPayment" 
                                    wire:loading.attr="disabled"
                                    wire:target="rejectPayment"
                                    class="mt-3 w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition text-sm font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span wire:loading.remove wire:target="rejectPayment">Tolak Payment</span>
                                <span wire:loading wire:target="rejectPayment">Processing...</span>
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Verification History -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Verifikasi</h3>
                        
                        @if($payment->isVerified())
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Payment Diverifikasi</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $payment->updated_at->format('d M Y H:i') }}</p>
                                    @if($payment->verifiedBy)
                                        <p class="text-xs text-gray-600 mt-1">Oleh: {{ $payment->verifiedBy->name }}</p>
                                    @endif
                                    @if($payment->catatan)
                                        <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                            <p class="text-xs text-gray-700 italic">"{{ $payment->catatan }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Payment Ditolak</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $payment->updated_at->format('d M Y H:i') }}</p>
                                    @if($payment->verifiedBy)
                                        <p class="text-xs text-gray-600 mt-1">Oleh: {{ $payment->verifiedBy->name }}</p>
                                    @endif
                                    @if($payment->catatan)
                                        <div class="mt-3 p-3 bg-red-50 rounded-lg border border-red-200">
                                            <p class="text-xs text-red-700 font-medium">"{{ $payment->catatan }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>