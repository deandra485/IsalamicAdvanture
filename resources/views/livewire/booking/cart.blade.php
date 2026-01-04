<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Keranjang Belanja</h1>
            <span class="bg-emerald-100 text-emerald-800 text-sm font-semibold px-4 py-1.5 rounded-full">
                {{ count($cart) }} Item
            </span>
        </div>

        @if(session()->has('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-8 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center text-emerald-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-8 space-y-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @foreach($cart as $key => $item)
                                <li class="p-6 transition-colors hover:bg-gray-50/50" wire:key="cart-{{ $key }}">
                                    <div class="flex flex-col sm:flex-row gap-6">
                                        
                                        <div class="flex-shrink-0 relative group">
                                            <div class="w-full sm:w-32 h-32 rounded-xl overflow-hidden bg-gray-100 border border-gray-100">
                                                @if(isset($item['equipment']['primary_image']))
                                                    <img src="{{ Storage::url($item['equipment']['primary_image']['image_url']) }}" 
                                                         alt="{{ $item['equipment']['nama_peralatan'] }}"
                                                         class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex-1 flex flex-col justify-between">
                                            <div>
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">
                                                            {{ $item['equipment']['category']['nama_kategori'] ?? 'Equipment' }}
                                                        </p>
                                                        <h3 class="text-lg font-bold text-gray-900 leading-tight">
                                                            <a href="#" class="hover:text-emerald-600 transition-colors">
                                                                {{ $item['equipment']['nama_peralatan'] }}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                    
                                                    <button wire:click="removeItem('{{ $key }}')"
                                                            wire:confirm="Hapus item ini dari keranjang?"
                                                            class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-md hover:bg-red-50">
                                                        <span class="sr-only">Hapus</span>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>

                                                <div class="mt-3 flex flex-wrap gap-2">
                                                    <div class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 text-xs font-medium">
                                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        {{ \Carbon\Carbon::parse($item['tanggal_mulai'])->format('d M') }} - {{ \Carbon\Carbon::parse($item['tanggal_selesai'])->format('d M Y') }}
                                                    </div>
                                                    <div class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-medium">
                                                        <svg class="w-3.5 h-3.5 mr-1.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        {{ $item['durasi'] }} Hari
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                                                
                                                <div class="flex items-center">
                                                    <label class="sr-only">Jumlah</label>
                                                    <div class="flex items-center border border-gray-200 rounded-full bg-white shadow-sm">
                                                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-l-full transition-colors {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                                        </button>
                                                        <span class="w-8 text-center text-sm font-semibold text-gray-900 select-none">{{ $item['quantity'] }}</span>
                                                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-r-full transition-colors">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                                        </button>
                                                    </div>
                                                    <span class="ml-3 text-xs text-gray-500">x Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}</span>
                                                </div>

                                                <div class="text-right">
                                                    <p class="text-xs text-gray-500 mb-0.5">Subtotal</p>
                                                    <p class="text-xl font-bold text-emerald-600">
                                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
                             <button wire:click="clearCart" 
                                    wire:confirm="Kosongkan semua item dari keranjang?"
                                    class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Kosongkan Keranjang
                            </button>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 sticky top-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Ringkasan Pesanan
                        </h2>

                        <div class="space-y-4 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Jumlah Item</span>
                                <span class="font-medium text-gray-900">{{ count($cart) }} jenis</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Unit</span>
                                <span class="font-medium text-gray-900">{{ collect($cart)->sum('quantity') }} unit</span>
                            </div>
                            
                            <div class="border-t border-dashed border-gray-200 my-4"></div>

                            <div class="flex justify-between items-center">
                                <span class="text-base font-semibold text-gray-900">Total Harga</span>
                                <span class="text-2xl font-bold text-emerald-600">
                                    Rp {{ number_format($this->getTotal(), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">
                            <a href="{{ route('user.checkout') }}" class="w-full flex justify-center items-center px-6 py-3.5 border border-transparent text-sm font-bold rounded-xl text-white bg-gray-900 hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Lanjut ke Checkout
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            
                            <a href="{{ route('equipment.index') }}" class="w-full flex justify-center items-center px-6 py-3.5 border border-gray-200 text-sm font-semibold rounded-xl text-gray-600 bg-white hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                Lanjut Belanja
                            </a>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-2 gap-2 text-xs text-gray-400 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span>Pembayaran Aman</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Jaminan Alat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-md mx-auto text-center py-20">
                <div class="bg-white rounded-full h-40 w-40 flex items-center justify-center mx-auto mb-6 shadow-sm border border-emerald-100 relative">
                    <div class="absolute inset-0 rounded-full animate-pulse bg-emerald-50 opacity-50"></div>
                    <svg class="w-20 h-20 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjangmu Kosong</h2>
                <p class="text-gray-500 mb-8 leading-relaxed">Sepertinya kamu belum memilih peralatan petualanganmu. Yuk, cari perlengkapan terbaik sekarang!</p>
                <a href="{{ route('equipment.index') }}" class="inline-flex items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 transition-all duration-300 shadow-lg hover:shadow-emerald-500/40 transform hover:-translate-y-1">
                    Mulai Belanja
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        @endif
    </div>
</div>