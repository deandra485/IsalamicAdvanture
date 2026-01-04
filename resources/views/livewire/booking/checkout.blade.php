<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-500">
                    <li class="inline-flex items-center">
                        <a href="{{ route('user.cart') }}" class="hover:text-emerald-600 transition-colors">Keranjang</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 font-medium text-gray-900">Checkout</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengiriman & Pembayaran</h1>
            <p class="mt-2 text-gray-600">Lengkapi data di bawah ini untuk menyelesaikan pesanan Anda.</p>
        </div>

        @if(session()->has('error'))
            <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="processCheckout">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-8 space-y-8">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full text-sm font-bold mr-3">1</span>
                            Metode Pengambilan
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative cursor-pointer group">
                                <input type="radio" wire:model.live="metodePengambilan" value="pickup" class="peer sr-only">
                                <div class="p-5 border-2 border-gray-200 rounded-xl hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all duration-200 h-full flex flex-col">
                                    <div class="flex items-center justify-between mb-2">
                                        <svg class="w-8 h-8 text-gray-400 peer-checked:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center">
                                            <div class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </div>
                                    </div>
                                    <span class="block font-bold text-gray-900">Pickup di Toko</span>
                                    <span class="block text-sm text-gray-500 mt-1">Ambil sendiri barang di lokasi kami tanpa biaya tambahan.</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group">
                                <input type="radio" wire:model.live="metodePengambilan" value="delivery" class="peer sr-only">
                                <div class="p-5 border-2 border-gray-200 rounded-xl hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all duration-200 h-full flex flex-col">
                                    <div class="flex items-center justify-between mb-2">
                                        <svg class="w-8 h-8 text-gray-400 peer-checked:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center">
                                            <div class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </div>
                                    </div>
                                    <span class="block font-bold text-gray-900">Delivery</span>
                                    <span class="block text-sm text-gray-500 mt-1">Kami antar peralatan langsung ke alamat tujuan Anda.</span>
                                </div>
                            </label>
                        </div>

                        @if($metodePengambilan === 'delivery')
                        <div class="mt-6 animate-fade-in-down">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Lengkap Pengiriman <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea wire:model="alamatPengiriman"
                                          rows="3"
                                          class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition-shadow sm:text-sm p-4"
                                          placeholder="Contoh: Jl. Merdeka No. 123, Kel. Suka Maju, Jakarta Selatan..."></textarea>
                                <div class="absolute top-3 right-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                            </div>
                            @error('alamatPengiriman')
                                <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full text-sm font-bold mr-3">2</span>
                            Metode Pembayaran
                        </h2>
                        
                        <div class="space-y-3">
                            <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group">
                                <input type="radio" wire:model="metodePembayaran" value="transfer_bank" class="peer sr-only">
                                <div class="flex items-center justify-center w-12 h-12 bg-blue-50 text-blue-600 rounded-lg mr-4 border border-blue-100 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                </div>
                                <div class="flex-grow">
                                    <span class="block font-semibold text-gray-900 group-hover:text-emerald-700 transition-colors">Transfer Bank</span>
                                    <span class="block text-xs text-gray-500">BCA, Mandiri, BRI, BNI</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-emerald-500 rounded-xl pointer-events-none"></div>
                            </label>

                            <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group">
                                <input type="radio" wire:model="metodePembayaran" value="e_wallet" class="peer sr-only">
                                <div class="flex items-center justify-center w-12 h-12 bg-purple-50 text-purple-600 rounded-lg mr-4 border border-purple-100 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="flex-grow">
                                    <span class="block font-semibold text-gray-900 group-hover:text-emerald-700 transition-colors">E-Wallet (QRIS)</span>
                                    <span class="block text-xs text-gray-500">GoPay, OVO, Dana, ShopeePay</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-emerald-500 rounded-xl pointer-events-none"></div>
                            </label>

                            <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group">
                                <input type="radio" wire:model="metodePembayaran" value="cod" class="peer sr-only">
                                <div class="flex items-center justify-center w-12 h-12 bg-green-50 text-green-600 rounded-lg mr-4 border border-green-100 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div class="flex-grow">
                                    <span class="block font-semibold text-gray-900 group-hover:text-emerald-700 transition-colors">Cash on Delivery (COD)</span>
                                    <span class="block text-xs text-gray-500">Bayar saat barang diterima</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-emerald-500 rounded-xl pointer-events-none"></div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Catatan Tambahan</h2>
                        <textarea wire:model="catatanCustomer"
                                  rows="3"
                                  class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition-shadow p-4 text-sm"
                                  placeholder="Ada instruksi khusus? Misal: 'Tolong hubungi saya sebelum pengiriman'"></textarea>
                    </div>
                </div>

                <div class="lg:col-span-4 sticky top-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 overflow-hidden">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($cart as $item)
                            <div class="flex gap-3 text-sm">
                                <div class="w-12 h-12 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                    @if(isset($item['equipment']['primary_image']))
                                        <img src="{{ Storage::url($item['equipment']['primary_image']['image_url']) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">IMG</div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-800 line-clamp-1">{{ $item['equipment']['nama_peralatan'] }}</p>
                                    <p class="text-gray-500 text-xs mt-0.5">
                                        {{ $item['quantity'] }} unit &times; {{ $item['durasi'] }} hari
                                    </p>
                                </div>
                                <div class="font-semibold text-gray-900 text-right">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="space-y-3 pt-4 border-t border-dashed border-gray-200 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium">Rp {{ number_format(collect($cart)->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between {{ $metodePengambilan === 'delivery' ? 'text-emerald-600' : 'text-gray-500' }}">
                                <span>Biaya Pengiriman</span>
                                @if($metodePengambilan === 'delivery')
                                    <span class="font-medium">Gratis (Promo)</span> 
                                    @else
                                    <span class="font-medium">-</span>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="text-base font-bold text-gray-900">Total Tagihan</span>
                                <span class="text-2xl font-bold text-emerald-600">
                                    Rp {{ number_format(collect($cart)->sum('subtotal'), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="w-full flex justify-center items-center px-6 py-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gray-900 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 shadow-lg transform active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span wire:loading.remove class="flex items-center">
                                    Buat Pesanan Sekarang
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                                <span wire:loading class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>

                            <a href="{{ route('user.cart') }}" class="w-full flex justify-center items-center px-6 py-3 border border-gray-200 text-sm font-semibold rounded-xl text-gray-600 bg-white hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                Kembali ke Keranjang
                            </a>
                        </div>
                        
                        <div class="mt-6 text-center">
                             <p class="text-xs text-gray-400">Dengan menekan tombol di atas, Anda menyetujui <a href="#" class="underline hover:text-gray-600">Syarat & Ketentuan</a> kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>