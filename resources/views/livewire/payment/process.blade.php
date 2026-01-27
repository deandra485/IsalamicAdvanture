<div class="min-h-screen bg-gray-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="mb-8">
            <nav class="mb-4 flex text-sm font-medium text-gray-500">
                <a href="/" class="hover:text-indigo-600 transition">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('user.bookings.history') }}" class="hover:text-indigo-600 transition">Bookings</a>
                <span class="mx-2">/</span>
                <span class="text-indigo-600">Payment</span>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selesaikan Pembayaran</h1>
                    <p class="mt-1 text-gray-500">Booking ID: <span class="font-mono font-bold text-indigo-600">#{{ $booking->id }}</span></p>
                </div>
                @if($booking->payment->status_pembayaran === 'pending')
                <div class="mt-4 md:mt-0 flex items-center bg-orange-50 text-orange-700 px-4 py-2 rounded-lg text-sm font-medium border border-orange-100">
                    <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Menunggu Pembayaran
                </div>
                @endif
            </div>
        </div>

        @if (session()->has('error'))
        <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-200 shadow-sm flex items-start gap-3">
            <svg class="h-6 w-6 text-red-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-gray-900">Status Transaksi</h2>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-orange-100 text-orange-700 border-orange-200',
                                    'verified' => 'bg-green-100 text-green-700 border-green-200',
                                    'failed' => 'bg-red-100 text-red-700 border-red-200',
                                ];
                                $statusClass = $statusColors[$booking->payment->status_pembayaran] ?? 'bg-gray-100 text-gray-700';
                                
                                $statusLabel = $booking->payment->status_pembayaran;
                                if($booking->payment->status_pembayaran === 'pending' && $booking->payment->bukti_pembayaran_url) {
                                    $statusLabel = 'Menunggu Verifikasi';
                                    $statusClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                } elseif($booking->payment->status_pembayaran === 'pending') {
                                    $statusLabel = 'Belum Dibayar';
                                }
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold border uppercase tracking-wide {{ $statusClass }}">
                                {{ ucfirst($statusLabel) }}
                            </span>
                        </div>

                        @if($booking->payment->bukti_pembayaran_url)
                            <div class="bg-blue-50/50 rounded-xl p-6 border border-blue-100 flex gap-4">
                                <div class="bg-blue-100 p-3 rounded-full h-fit text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-blue-900 text-lg">Bukti Terkirim</h3>
                                    <p class="text-blue-700 mt-1 mb-4 text-sm leading-relaxed">
                                        Tim kami sedang memverifikasi bukti pembayaran Anda. Proses ini biasanya memakan waktu maksimal 1x24 jam.
                                    </p>
                                    <div class="flex items-center gap-3 text-sm">
                                        <a href="{{ Storage::url($booking->payment->bukti_pembayaran_url) }}" target="_blank" class="text-indigo-600 font-semibold hover:text-indigo-800 hover:underline flex items-center">
                                            Lihat Bukti
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                        <span class="text-gray-300">|</span>
                                        <span class="text-gray-500">Dikirim {{ $booking->payment->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="relative flex items-center justify-between w-full mb-8">
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 -z-10 rounded"></div>
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-indigo-600 -z-10 rounded transition-all duration-500" 
                                     style="width: {{ $selectedMethod ? '50%' : '0%' }}"></div>
                                
                                <div class="flex flex-col items-center bg-white px-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 {{ $selectedMethod ? 'bg-indigo-600 text-white' : 'bg-indigo-600 text-white' }}">1</div>
                                    <span class="text-xs font-semibold mt-2 text-indigo-600">Metode</span>
                                </div>
                                <div class="flex flex-col items-center bg-white px-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 {{ $selectedMethod ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-500' }}">2</div>
                                    <span class="text-xs font-semibold mt-2 {{ $selectedMethod ? 'text-indigo-600' : 'text-gray-400' }}">Bayar</span>
                                </div>
                                <div class="flex flex-col items-center bg-white px-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 bg-gray-200 text-gray-500">3</div>
                                    <span class="text-xs font-semibold mt-2 text-gray-400">Upload</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-800 mb-3">Pilih Metode Pembayaran</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <button type="button" wire:click="selectMethod('transfer_bank')"
                                        class="relative group p-4 border rounded-xl text-left transition-all duration-200 shadow-sm
                                        {{ $selectedMethod === 'transfer_bank' 
                                            ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-600' 
                                            : 'border-gray-200 bg-white hover:border-indigo-300 hover:shadow-md' }}">
                                        @if($selectedMethod === 'transfer_bank')
                                            <div class="absolute top-2 right-2 text-indigo-600"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></div>
                                        @endif
                                        <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        </div>
                                        <span class="block font-bold text-gray-900">Transfer Bank</span>
                                        <span class="text-xs text-gray-500">BCA, Mandiri, BNI</span>
                                    </button>

                                    <button type="button" wire:click="selectMethod('e_wallet')"
                                        class="relative group p-4 border rounded-xl text-left transition-all duration-200 shadow-sm
                                        {{ $selectedMethod === 'e_wallet' 
                                            ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-600' 
                                            : 'border-gray-200 bg-white hover:border-indigo-300 hover:shadow-md' }}">
                                        @if($selectedMethod === 'e_wallet')
                                            <div class="absolute top-2 right-2 text-indigo-600"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></div>
                                        @endif
                                        <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="block font-bold text-gray-900">E-Wallet</span>
                                        <span class="text-xs text-gray-500">GoPay, OVO, Dana</span>
                                    </button>

                                    <button type="button" wire:click="selectMethod('cod')"
                                        class="relative group p-4 border rounded-xl text-left transition-all duration-200 shadow-sm
                                        {{ $selectedMethod === 'cod' 
                                            ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-600' 
                                            : 'border-gray-200 bg-white hover:border-indigo-300 hover:shadow-md' }}">
                                        @if($selectedMethod === 'cod')
                                            <div class="absolute top-2 right-2 text-indigo-600"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></div>
                                        @endif
                                        <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <span class="block font-bold text-gray-900">COD</span>
                                        <span class="text-xs text-gray-500">Bayar di Tempat</span>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @if($selectedMethod === 'transfer_bank')
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 animate-fade-in-down">
                                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                                        Rekening Tujuan
                                    </h3>
                                    <div class="space-y-4">
                                        @foreach($bankAccounts as $account)
                                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
                                            <div class="flex items-center gap-4 w-full">
                                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-xl shrink-0">
                                                    {{ $account['logo'] }}
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">{{ $account['name'] }}</p>
                                                    <p class="text-lg font-mono font-bold text-gray-900 tracking-wider">{{ $account['account_number'] }}</p>
                                                    <p class="text-xs text-gray-400 uppercase">A.N {{ $account['account_name'] }}</p>
                                                </div>
                                            </div>
                                            <button onclick="navigator.clipboard.writeText('{{ $account['account_number'] }}'); alert('Nomor rekening disalin!')" 
                                                class="text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-lg text-sm font-medium transition w-full sm:w-auto text-center">
                                                Salin
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if($selectedMethod === 'e_wallet')
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 animate-fade-in-down">
                                    <h3 class="font-bold text-gray-900 mb-4">Scan QR atau Transfer</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        {{-- <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                                            <div class="h-10 flex items-center justify-center mb-2 font-bold text-blue-600">GOPAY</div>
                                            <p class="text-sm font-mono font-bold">0812-3456-7890</p>
                                        </div>
                                        <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                                            <div class="h-10 flex items-center justify-center mb-2 font-bold text-purple-600">OVO</div>
                                            <p class="text-sm font-mono font-bold">0812-3456-7890</p>
                                        </div> --}}
                                        <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                                            <div class="h-10 flex items-center justify-center mb-2 font-bold text-blue-500">DANA</div>
                                            <p class="text-sm font-mono font-bold">0813-2495-0366</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($selectedMethod === 'cod')
                                <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-200 flex items-start animate-fade-in-down">
                                    <div class="p-2 bg-yellow-100 rounded-full mr-4 text-yellow-600 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-yellow-900 mb-1">Siapkan Uang Tunai</h3>
                                        <p class="text-sm text-yellow-800 leading-relaxed">
                                            Mohon siapkan uang pas sebesar <strong class="text-black">Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}</strong> saat tim kami mengantarkan peralatan atau saat Anda mengambil barang.
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if(!$booking->payment->bukti_pembayaran_url && $selectedMethod !== 'cod' && $selectedMethod)
                <form wire:submit="uploadPaymentProof" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm mr-3">3</span>
                        Konfirmasi Pembayaran
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <label class="flex flex-col items-center justify-center w-full h-56 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-400 transition-all duration-300">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        @if($bukti_pembayaran)
                                            <div class="relative">
                                                <img src="{{ $bukti_pembayaran->temporaryUrl() }}" class="h-40 object-contain rounded-lg shadow-md">
                                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition rounded-lg text-white font-medium">Ubah Foto</div>
                                            </div>
                                        @else
                                            <div class="p-4 bg-white rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                            </div>
                                            <p class="mb-2 text-sm text-gray-900 font-semibold">Klik untuk upload bukti</p>
                                            <p class="text-xs text-gray-500">PNG, JPG (Max. 2MB)</p>
                                        @endif
                                    </div>
                                    <input type="file" wire:model="bukti_pembayaran" accept="image/*" class="hidden">
                                </label>
                            </div>
                            @error('bukti_pembayaran') 
                                <p class="mt-2 text-sm text-red-600 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @enderror
                            
                            <div wire:loading wire:target="bukti_pembayaran" class="mt-3 w-full bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Sedang mengupload gambar...
                            </div>
                        </div>

                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea id="catatan" wire:model="catatan" rows="3" 
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition" 
                                placeholder="Contoh: Transfer atas nama Budi Santoso..."></textarea>
                            @error('catatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="uploadPaymentProof">Kirim Bukti Pembayaran</span>
                            <span wire:loading wire:target="uploadPaymentProof" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
                @endif

                @if($selectedMethod === 'cod')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Metode COD Dipilih</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Pesanan Anda telah dicatat. Silakan lakukan pembayaran saat pengambilan barang. Tim kami akan segera menghubungi Anda via WhatsApp.</p>
                    <a href="{{ route('user.bookings.history') }}" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Riwayat Booking
                    </a>
                </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gray-900 px-6 py-4">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Ringkasan Pesanan
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4 mb-6">
                                @foreach($booking->items as $item)
                                <div class="flex items-start justify-between group">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 transition">{{ $item->item_name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $item->quantity }} unit &times; {{ $booking->durasi_hari }} hari
                                        </p>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                                @endforeach
                            </div>

                            <hr class="border-dashed border-gray-200 my-4">

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Biaya Layanan</span>
                                    <span class="text-green-600 font-medium">Gratis</span>
                                </div>
                            </div>

                            <hr class="border-gray-100 my-4">

                            <div class="flex justify-between items-end">
                                <span class="text-sm font-bold text-gray-700">Total Tagihan</span>
                                <span class="text-2xl font-extrabold text-indigo-600">
                                    Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex items-center justify-center gap-2 text-xs text-gray-500">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Transaksi Aman & Terenkripsi
                        </div>
                    </div>

                    <div class="bg-indigo-900 rounded-2xl p-6 text-center text-white shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 rounded-full bg-white opacity-10 blur-xl"></div>
                        <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-20 h-20 rounded-full bg-indigo-500 opacity-20 blur-xl"></div>
                        
                        <h4 class="font-bold text-lg mb-2 relative z-10">Butuh Bantuan?</h4>
                        <p class="text-indigo-200 text-sm mb-4 relative z-10">Tim CS kami siap membantu Anda 24/7 jika ada kendala pembayaran.</p>
                        
                        <div class="flex gap-2 relative z-10">
                            <a href="https://wa.me/6281324950366" target="_blank" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-8.683-2.031-9.667-.272-.099-.47-.149-.669-.149-.198 0-.42.074-.642.32-.222.249-.865.841-.865 2.053 0 1.211.865 2.382.988 2.553.124.173 1.705 2.603 4.129 3.649 1.575.678 2.193.543 2.987.509.791-.034 1.758-.716 2.006-1.41.248-.694.248-1.289.173-1.413z"/></svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>