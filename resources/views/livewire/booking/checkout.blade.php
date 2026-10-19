<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Checkout</h1>
            
            <div class="flex items-center w-full max-w-2xl mx-auto mb-8">
                <div class="flex items-center text-blue-600 relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-blue-600 bg-white flex items-center justify-center font-bold">✓</div>
                    <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-blue-600">Keranjang</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-blue-600 mx-4"></div>
                <div class="flex items-center text-blue-600 relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-blue-600 bg-blue-600 text-white flex items-center justify-center font-bold">2</div>
                    <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-blue-600">Pembayaran</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-200 mx-4"></div>
                <div class="flex items-center text-gray-400 relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-200 bg-white flex items-center justify-center font-bold">3</div>
                    <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Selesai</div>
                </div>
            </div>
        </div>

        @if(session()->has('error'))
            <div class="flex items-center p-4 mb-6 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-2 space-y-8">
                <form wire:submit.prevent="processCheckout" id="checkout-form">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-green-50 rounded-lg text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Metode Pembayaran</h2>
                        </div>

                        <div class="space-y-3">
                            <label class="relative block cursor-pointer">
                                <input type="radio" wire:model="metodePembayaran" value="transfer_bank" class="peer sr-only">
                                <div class="flex items-center p-4 pr-14 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50/30 hover:bg-gray-50 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 peer-checked:bg-green-100 peer-checked:text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                        </div>
                                        <span class="font-medium text-gray-900">Transfer Bank</span>
                                    </div>
                                </div>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-green-600 peer-checked:bg-green-600 flex items-center justify-center transition-all duration-200 pointer-events-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </label>

                            <label class="relative block cursor-pointer">
                                <input type="radio" wire:model="metodePembayaran" value="e_wallet" class="peer sr-only">
                                <div class="flex items-center p-4 pr-14 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50/30 hover:bg-gray-50 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 peer-checked:bg-green-100 peer-checked:text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-900 block">E-Wallet</span>
                                            <span class="text-xs text-gray-500">GoPay, OVO, Dana, ShopeePay</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-green-600 peer-checked:bg-green-600 flex items-center justify-center transition-all duration-200 pointer-events-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </label>

                            <label class="relative block cursor-pointer">
                                <input type="radio" wire:model="metodePembayaran" value="cod" class="peer sr-only">
                                <div class="flex items-center p-4 pr-14 bg-white border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50/30 hover:bg-gray-50 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 peer-checked:bg-green-100 peer-checked:text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <span class="font-medium text-gray-900">Cash on Delivery (COD)</span>
                                    </div>
                                </div>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-green-600 peer-checked:bg-green-600 flex items-center justify-center transition-all duration-200 pointer-events-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea wire:model="catatanCustomer" 
                                rows="2" 
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all outline-none resize-none text-sm"
                                placeholder="Misal: Tolong bungkus yang rapi..."></textarea>
                    </div>

                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-6 lg:p-8 sticky top-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>

                    <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cart as $item)
                            <div class="flex gap-3 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                <div class="w-16 h-16 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden border border-gray-200">
                                    @php
                                        $imagePath = ($item['type'] === 'equipment') ? ($item['equipment']['primary_image'] ?? null) : ($item['package']['image'] ?? null);
                                        $itemName = ($item['type'] === 'equipment') ? $item['equipment']['nama_peralatan'] : $item['package']['nama_paket'];
                                    @endphp
                                    
                                    @if($imagePath)
                                        <img src="{{ Storage::url($imagePath) }}" alt="{{ $itemName }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-gray-900 truncate" title="{{ $itemName }}">{{ $itemName }}</h4>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {{ $item['quantity'] }} item x 
                                        @if($item['type'] === 'equipment')
                                            {{ $item['durasi'] }} hari
                                        @endif
                                    </div>
                                    <div class="font-medium text-blue-600 text-sm mt-1">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 space-y-2 mb-6">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Subtotal</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format(collect($cart)->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        

                        <div class="border-t border-gray-200 pt-3 mt-2 flex justify-between items-end">
                            <span class="font-bold text-gray-900">Total Bayar</span>
                            <span class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format(collect($cart)->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button wire:click="processCheckout" 
                                wire:loading.attr="disabled"
                                class="w-full bg-blue-600 text-white py-3.5 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all transform active:scale-[0.98] flex items-center justify-center gap-2">
                            
                            <span wire:loading.remove>Buat Pesanan Sekarang</span>
                            
                            <div wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </div>
                        </button>

                        <a href="{{ route('booking.cart') }}" class="block w-full text-center text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors py-2">
                            Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>