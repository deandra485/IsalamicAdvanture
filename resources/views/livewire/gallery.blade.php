<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-600 mb-4 tracking-tight">Galeri Foto</h1>
            <p class="text-lg text-gray-500 font-light max-w-2xl mx-auto">Koleksi momen terbaik yang kami abadikan untuk Anda.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($images as $image)
                <div 
                    wire:click="openImage({{ $image['id'] }})"
                    class="group relative bg-white rounded-2xl shadow-sm hover:shadow-2xl cursor-pointer overflow-hidden transition-all duration-300 transform hover:-translate-y-1"
                >
                    <div class="aspect-w-4 aspect-h-3 bg-gray-100 overflow-hidden">
                        <img 
                            src="{{ $image['thumb'] }}" 
                            alt="{{ $image['title'] }}"
                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110"
                            loading="lazy"
                        >
                    </div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="text-lg font-bold text-white mb-1 leading-tight">{{ $image['title'] }}</h3>
                            <p class="text-sm text-gray-300 line-clamp-1">{{ $image['description'] }}</p>
                        </div>
                    </div>

                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 scale-75 group-hover:scale-100">
                        <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-full p-2.5 shadow-lg text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($showModal && $selectedImage)
            <div 
                class="fixed inset-0 z-50 overflow-y-auto"
                x-data="{ show: @entangle('showModal') }"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div 
                    class="fixed inset-0 bg-black/90 backdrop-blur-sm transition-opacity"
                    wire:click="closeModal"
                ></div>

                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="relative w-full max-w-6xl">
                        
                        <button 
                            wire:click="closeModal"
                            class="absolute -top-12 right-0 md:-right-8 text-white/70 hover:text-white transition-colors"
                        >
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <div class="relative bg-black rounded-2xl shadow-2xl overflow-hidden ring-1 ring-white/10 flex flex-col md:flex-row">
                            
                            <div class="flex-1 relative flex items-center justify-center bg-zinc-900 min-h-[50vh]">
                                <img 
                                    src="{{ $selectedImage['url'] }}" 
                                    alt="{{ $selectedImage['title'] }}"
                                    class="w-full h-auto max-h-[85vh] object-contain"
                                >
                            </div>
                            
                            <div class="w-full md:w-80 lg:w-96 bg-white p-8 flex flex-col justify-center border-l border-gray-100">
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $selectedImage['title'] }}</h2>
                                <div class="w-10 h-1 bg-indigo-500 rounded-full mb-4"></div>
                                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                                    {{ $selectedImage['description'] }}
                                </p>
                            </div>

                            <button 
                                wire:click="previousImage"
                                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 backdrop-blur text-white rounded-full p-3 transition-all border border-white/10"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>

                            <button 
                                wire:click="nextImage"
                                class="absolute right-4 md:right-[21rem] lg:right-[25rem] top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 backdrop-blur text-white rounded-full p-3 transition-all border border-white/10"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>