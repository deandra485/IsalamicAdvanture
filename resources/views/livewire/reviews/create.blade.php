<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
            Bagaimana Perjalanan Anda?
        </h1>
        <p class="mt-3 text-lg text-gray-500">
            Bagikan pengalaman seru Anda mendaki 
            <span class="font-semibold text-blue-600">{{ $booking->package->mountain->nama_gunung ?? 'gunung ini' }}</span> 
            untuk membantu pendaki lain.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Detail Pendakian</h3>
                </div>

                @php
                    $tanggalMulai = \Carbon\Carbon::parse($booking->tanggal_mulai);
                    $tanggalSelesai = \Carbon\Carbon::parse($booking->tanggal_selesai);

                    // Paksa minimal 2 hari
                    if ($tanggalSelesai->lt($tanggalMulai->copy()->addDays(2))) {
                        $tanggalSelesai = $tanggalMulai->copy()->addDays(2);
                    }
                @endphp

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Booking ID</span>
                        <span class="font-mono text-sm font-medium text-gray-900 bg-gray-100 px-2 py-1 rounded">#{{ $booking->id }}</span>
                    </div>
                    
                    <div class="py-2">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Waktu</span>
                        <div class="mt-2 flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $tanggalMulai->format('d M Y') }} - {{ $tanggalSelesai->format('d M Y') }}
                        </div>
                    </div>

                    <div class="py-2">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Durasi</span>
                        <div class="mt-2 flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $booking->durasi_hari }} Hari Perjalanan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <form wire:submit.prevent="submit" class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8 space-y-8">
                    
                    <div class="text-center">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Berapa bintang untuk pengalaman ini? <span class="text-red-500">*</span>
                        </label>
                        <div class="inline-flex items-center justify-center p-4 bg-gray-50 rounded-2xl">
                            <div class="flex items-center space-x-1 sm:space-x-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                        wire:click="setRating({{ $i }})"
                                        class="group focus:outline-none transition-all duration-200 transform hover:scale-110">
                                        <svg class="w-10 h-10 sm:w-12 sm:h-12 {{ $rating >= $i ? 'text-yellow-400 fill-current' : 'text-gray-300' }} group-hover:text-yellow-300 transition-colors" 
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </div>
                        @if($rating > 0)
                            <p class="mt-3 text-lg font-medium text-gray-800 animate-fade-in-up">
                                {{ $rating == 5 ? 'Luar Biasa!' : ($rating >= 4 ? 'Sangat Bagus' : ($rating >= 3 ? 'Cukup Bagus' : 'Kurang Memuaskan')) }}
                            </p>
                        @endif
                        @error('rating')
                            <p class="mt-2 text-sm text-red-600 font-medium bg-red-50 inline-block px-3 py-1 rounded-full">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ceritakan Pengalaman Anda
                        </label>
                        <div class="relative">
                            <textarea wire:model="komentar" 
                                rows="5" 
                                placeholder="Bagaimana pemandangan di sana? Bagaimana pelayanan guide-nya? Ceritakan hal menarik..."
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm placeholder-gray-400 bg-gray-50 focus:bg-white transition-all"
                                maxlength="1000"></textarea>
                            
                            <div class="absolute bottom-3 right-3 text-xs text-gray-400 bg-white/80 px-2 py-1 rounded">
                                {{ strlen($komentar) }}/1000
                            </div>
                        </div>
                        @error('komentar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Dokumentasi (Opsional)
                        </label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-300 transition-all duration-300 group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <div class="p-3 bg-white rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="mb-1 text-sm text-gray-500">
                                        <span class="font-semibold text-blue-600">Klik upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-400">PNG, JPG, JPEG (Max 2MB)</p>
                                </div>
                                <input type="file" wire:model="photos" multiple accept="image/*" class="hidden" />
                                
                                <div wire:loading wire:target="photos" class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-2xl backdrop-blur-sm">
                                    <div class="flex items-center text-blue-600">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="font-medium text-sm">Mengupload...</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        @error('photos.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if(!empty($photos))
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-6 animate-fade-in">
                                @foreach($photos as $index => $photo)
                                    <div class="relative group aspect-square rounded-xl overflow-hidden shadow-sm border border-gray-200">
                                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                                        <button type="button" 
                                            wire:click="removePhoto({{ $index }})"
                                            class="absolute top-2 right-2 p-1.5 bg-red-500/90 text-white rounded-full opacity-0 group-hover:opacity-100 transform translate-y-[-10px] group-hover:translate-y-0 transition-all duration-200 hover:bg-red-600 shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-5 sm:px-8 flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div class="text-xs text-gray-500 hidden sm:block">
                        <span class="font-medium">Note:</span> Review akan dimoderasi sebelum tayang.
                    </div>
                    
                    <div class="flex gap-3 justify-end w-full sm:w-auto">
                        <a href="{{ route('user.bookings.history') }}" 
                            class="px-6 py-2.5 rounded-xl text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                            Batal
                        </a>
                        
                        <button type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="submit,photos"
                            class="flex-1 sm:flex-none px-8 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-70 disabled:cursor-not-allowed transition-all transform hover:-translate-y-0.5">
                            <span wire:loading.remove wire:target="submit">Kirim Review</span>
                            <div wire:loading wire:target="submit" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mengirim...
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>