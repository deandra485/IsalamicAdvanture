<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Ulasan Saya</h1>
            <p class="text-slate-600">Kelola semua ulasan pendakian Anda dalam satu halaman</p>
        </div>

        <!-- Flash Messages -->
        @if(session()->has('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                    </svg>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm text-center">
                <div class="text-3xl font-bold text-slate-900">{{ $stats['total_reviews'] }}</div>
                <div class="text-sm text-slate-600 mt-1">Total Ulasan</div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200 shadow-sm text-center">
                <div class="text-3xl font-bold text-green-700">{{ $stats['approved_reviews'] }}</div>
                <div class="text-sm text-green-700 mt-1">Disetujui</div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-200 shadow-sm text-center">
                <div class="text-3xl font-bold text-yellow-700">{{ $stats['pending_reviews'] }}</div>
                <div class="text-sm text-yellow-700 mt-1">Menunggu</div>
            </div>
        </div>

        <!-- Write Review Section -->
        @if($bookingsCanReview->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-lg mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Tulis Ulasan Baru
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Anda memiliki {{ $bookingsCanReview->count() }} pendakian yang bisa direview</p>
                </div>

                <div class="p-6">
                    @if(!$showForm)
                        <!-- Select Booking -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($bookingsCanReview as $booking)
                                <button 
                                    wire:click="selectBooking({{ $booking->id }})"
                                    class="group text-left bg-slate-50 hover:bg-white border-2 border-slate-200 hover:border-blue-400 rounded-xl p-4 transition-all transform hover:scale-[1.02]"
                                >
                                    <div class="flex items-start gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                                {{ $booking->package->mountain->nama_gunung }}
                                            </h3>
                                            <p class="text-sm text-slate-600 mt-1">
                                                {{ $booking->package->nama_paket }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $booking->tanggal_mulai->format('d M Y') }}
                                            </p>
                                        </div>
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @else
                        <!-- Review Form -->
                        @php
                            $selectedBookingData = $bookingsCanReview->firstWhere('id', $selectedBooking);
                        @endphp

                        @if($selectedBookingData)
                            <form wire:submit.prevent="submit" class="space-y-6">
                                <!-- Selected Booking Info -->
                                <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-4 border border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-slate-900">{{ $selectedBookingData->package->mountain->nama_gunung }}</h3>
                                                <p class="text-sm text-slate-600">{{ $selectedBookingData->package->nama_paket }}</p>
                                            </div>
                                        </div>
                                        <button 
                                            type="button"
                                            wire:click="cancelForm"
                                            class="text-slate-400 hover:text-slate-600 transition-colors"
                                        >
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div>
                                    <label class="block text-lg font-bold text-slate-900 mb-4 text-center">
                                        Berikan Rating <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center justify-center gap-3 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button 
                                                type="button"
                                                wire:click="setRating({{ $i }})"
                                                class="focus:outline-none transition-all duration-200 transform hover:scale-110 active:scale-95"
                                            >
                                                <svg 
                                                    class="h-12 w-12 transition-all duration-200 {{ $rating >= $i ? 'text-yellow-400 fill-current drop-shadow-lg' : 'text-slate-300' }}"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            </button>
                                        @endfor
                                    </div>
                                    
                                    <div class="text-center">
                                        @if($rating > 0)
                                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 rounded-full border border-yellow-200">
                                                <span class="text-xl">
                                                    @if($rating == 1) 😞
                                                    @elseif($rating == 2) 😐
                                                    @elseif($rating == 3) 🙂
                                                    @elseif($rating == 4) 😊
                                                    @else 🤩
                                                    @endif
                                                </span>
                                                <span class="font-bold text-yellow-700">{{ $rating }} Bintang</span>
                                            </div>
                                        @else
                                            <p class="text-sm text-slate-500">Klik bintang untuk memberi rating</p>
                                        @endif
                                    </div>
                                    
                                    @error('rating')
                                        <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Comment -->
                                <div>
                                    <label for="komentar" class="block text-lg font-bold text-slate-900 mb-3">
                                        Ceritakan Pengalaman Anda <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <textarea 
                                            wire:model.live="komentar"
                                            id="komentar"
                                            rows="5"
                                            maxlength="500"
                                            class="w-full rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all px-4 py-3 resize-none"
                                            placeholder="Bagikan pengalaman, tips, atau saran untuk pendaki lain..."
                                        ></textarea>
                                        <div class="absolute bottom-3 right-3 text-xs font-medium {{ strlen($komentar) > 450 ? 'text-red-500' : 'text-slate-400' }}">
                                            {{ strlen($komentar) }}/500
                                        </div>
                                    </div>
                                    @error('komentar')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-4 pt-4">
                                    <button 
                                        type="button"
                                        wire:click="cancelForm"
                                        class="flex-1 px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all"
                                    >
                                        Batal
                                    </button>
                                    <button 
                                        type="submit"
                                        wire:loading.attr="disabled"
                                        class="flex-1 px-6 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2"
                                    >
                                        <span wire:loading.remove wire:target="submit">
                                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Kirim Review
                                        </span>
                                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Mengirim...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        <!-- Reviews List -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden">
            <div class="bg-slate-900 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Riwayat Ulasan
                </h2>
            </div>

            <div class="divide-y divide-slate-200">
                @forelse($reviews as $review)
                    <div class="p-6 hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">
                                    {{ $review->mountain->nama_gunung ?? 'N/A' }}
                                </h3>
                                <p class="text-sm text-slate-600 mt-1">
                                    {{ $review->booking->package->nama_paket ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $review->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            @if($review->is_approved)
                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">
                                    <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                    </svg>
                                    Menunggu
                                </span>
                            @endif
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center gap-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400 fill-current' : 'text-slate-300' }}" viewBox="0 0 24 24">
                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm font-bold text-slate-700">{{ $review->rating }}/5</span>
                        </div>

                        <!-- Comment -->
                        <p class="text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl">{{ $review->komentar }}</p>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Ulasan</h3>
                        <p class="text-slate-500">Selesaikan pendakian dan tulis ulasan pertama Anda!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>