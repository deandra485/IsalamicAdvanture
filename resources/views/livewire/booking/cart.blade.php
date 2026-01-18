<div class="container mx-auto px-4 py-12 max-w-6xl font-sans">
    
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Keranjang Belanja</h1>
        
        <div class="flex items-center w-full max-w-2xl mx-auto mb-8">
            <div class="flex items-center text-blue-600 relative">
                <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-blue-600 bg-blue-600 text-white flex items-center justify-center font-bold">1</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-blue-600">Keranjang</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-200 mx-4"></div>
            <div class="flex items-center text-gray-400 relative">
                <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-200 bg-white flex items-center justify-center font-bold">2</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Checkout</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-200 mx-4"></div>
            <div class="flex items-center text-gray-400 relative">
                <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-200 bg-white flex items-center justify-center font-bold">3</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Selesai</div>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-xl bg-green-50 shadow-sm" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <div class="lg:w-2/3 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 space-y-8">
                        @foreach($cart as $key => $item)
                            <div class="flex flex-col sm:flex-row gap-6 {{ !$loop->last ? 'border-b border-gray-100 pb-8' : '' }}">
                                
                                <div class="w-full sm:w-32 h-32 flex-shrink-0 relative group">
                                    <div class="w-full h-full rounded-xl overflow-hidden bg-gray-50 border border-gray-100">
                                        @php
                                            $imagePath = ($item['type'] === 'equipment') 
                                                ? ($item['equipment']['primary_image'] ?? null) 
                                                : ($item['package']['image'] ?? null);
                                            $itemName = ($item['type'] === 'equipment') 
                                                ? $item['equipment']['nama_peralatan'] 
                                                : $item['package']['nama_paket'];
                                        @endphp

                                        @if($imagePath)
                                            <img src="{{ Storage::url($imagePath) }}" 
                                                 alt="{{ $itemName }}" 
                                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900 leading-tight mb-1">{{ $itemName }}</h3>
                                                <div class="flex flex-wrap gap-2 mb-3">
                                                    @if($item['type'] === 'equipment')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                            {{ $item['equipment']['category']['nama_kategori'] ?? 'Equipment' }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                                                            Package
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <button wire:click="removeItem('{{ $key }}')" class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>

                                        <div class="text-sm text-gray-600 space-y-1 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            @if($item['type'] === 'equipment')
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <span>{{ \Carbon\Carbon::parse($item['tanggal_mulai'])->format('d M') }} - {{ \Carbon\Carbon::parse($item['tanggal_selesai'])->format('d M Y') }}</span>
                                                    <span class="text-gray-300">|</span>
                                                    <span class="font-medium text-gray-800">{{ $item['durasi'] }} Hari</span>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    @ Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }} / hari
                                                </div>
                                            @else
                                                <div class="text-xs text-gray-500">
                                                    <span class="font-medium text-gray-900 block mb-1">Paket Termasuk:</span>
                                                    <div class="flex flex-wrap gap-1">
                                                        @if(isset($item['package']['items']))
                                                            @foreach($item['package']['items'] as $packageItem)
                                                                <span class="bg-white border border-gray-200 px-2 py-0.5 rounded text-[10px] text-gray-600">
                                                                    {{ $packageItem['equipment']['nama_peralatan'] }} (x{{ $packageItem['quantity'] }})
                                                                </span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-end mt-4">
                                        <div class="flex items-center border border-gray-200 rounded-lg bg-white shadow-sm h-9">
                                            <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})" 
                                                    class="px-3 text-gray-500 hover:text-blue-600 hover:bg-gray-50 rounded-l-lg h-full transition-colors font-medium">
                                                -
                                            </button>
                                            <span class="px-3 text-sm font-semibold text-gray-900 border-x border-gray-100 min-w-[2.5rem] text-center">
                                                {{ $item['quantity'] }}
                                            </span>
                                            <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})" 
                                                    class="px-3 text-gray-500 hover:text-blue-600 hover:bg-gray-50 rounded-r-lg h-full transition-colors font-medium">
                                                +
                                            </button>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-xs text-gray-500 mb-0.5">Subtotal</div>
                                            <div class="text-lg font-bold text-blue-600">
                                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('equipment.index') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Lanjut Belanja
                    </a>
                    <button wire:click="clearCart" class="text-sm font-medium text-red-500 hover:text-red-700 hover:underline transition-colors">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 lg:p-8 sticky top-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Total Item</span>
                            <span class="font-medium text-gray-900">{{ count($cart) }} item</span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Total Barang (Qty)</span>
                            <span class="font-medium text-gray-900">{{ collect($cart)->sum('quantity') }} unit</span>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-100 flex justify-between items-end">
                            <span class="text-base font-semibold text-gray-900">Total Biaya</span>
                            <span class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format($this->getTotal(), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('booking.checkout') }}" class="block w-full bg-blue-600 text-white text-center py-4 rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transform hover:-translate-y-0.5 transition-all duration-200">
                        Lanjut ke Checkout
                    </a>

                    <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>Pembayaran Aman & Terenkripsi</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="w-48 h-48 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-8 max-w-sm text-center">Sepertinya Anda belum menambahkan peralatan apa pun. Mari temukan gear terbaik untuk kebutuhan Anda.</p>
            <a href="{{ route('equipment.index') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                <span>Mulai Belanja</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    @endif
</div>