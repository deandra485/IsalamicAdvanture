<div class="min-h-screen flex bg-white relative">
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-full lg:w-[60%] bg-white z-10">
        <div class="mx-auto w-full max-w-lg">
            
            <div class="text-left">
                <a href="/" class="flex items-center gap-2 text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                      <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.75 3c1.99 0 3.751 1.08 4.75 2.735A5.5 5.5 0 0117.25 3c3.036 0 5.5 2.322 5.5 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.47 0l-.003-.001z" />
                    </svg>
                    <h1 class="text-2xl font-bold">IslamicAdvanture</h1>
                </a>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 tracking-tight">
                    Mulai Petualangan Baru Anda
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Sudah bergabung sebelumnya?
                    <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500 transition">
                        Masuk ke akun Anda di sini
                    </a>
                </p>
            </div>

            <div class="mt-8">
                <div>
                    <a href="{{ route('auth.google') }}" 
               class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150 transform hover:scale-[1.01]">
                <img class="h-5 w-5 mr-2" src="https://www.svgrepo.com/show/475656/google-color.svg" loading="lazy" alt="google logo">
                <span>Daftar dengan Google</span>
            </a>
                </div>

                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Atau daftar dengan email</span>
                    </div>
                </div>
            </div>
            <form wire:submit="register" class="mt-6 space-y-6">
                
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                     <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input id="name" type="text" wire:model="name" required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-200"
                                placeholder="Nama Anda">
                        </div>
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" type="email" wire:model="email" required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-200"
                                placeholder="nama@email.com">
                        </div>
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                 <div>
                    <label for="no_telepon" class="block text-sm font-semibold text-gray-700 mb-1">
                        No. Telepon
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                           <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <input id="no_telepon" type="text" wire:model="no_telepon" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-200"
                            placeholder="08123456789">
                    </div>
                    @error('no_telepon') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1">
                        Alamat Lengkap
                    </label>
                     <div class="relative rounded-md shadow-sm">
                        <textarea id="alamat" wire:model="alamat" rows="2" 
                             class="block w-full px-3 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-200"
                            placeholder="Alamat domisili Anda"></textarea>
                     </div>
                    @error('alamat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 pt-2">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" type="password" wire:model="password" required 
                                 class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-200"
                                placeholder="••••••••">
                        </div>
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <input id="password_confirmation" type="password" wire:model="password_confirmation" required 
                                 class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-200"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove>Buat Akun Sekarang</span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                    <p class="mt-4 text-xs text-center text-gray-500">
                        Dengan mendaftar, Anda menyetujui Syarat & Ketentuan kami.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <div class="hidden lg:block relative w-0 flex-1">
        <img class="absolute inset-0 h-full w-full object-cover" 
             src="https://images.unsplash.com/photo-1543432681-7294c9df2093?ixlib=rb-4.0.3&auto=format&fit=crop&w=1374&q=80" 
             alt="Islamic Adventure Background">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/50 to-teal-900/20 mix-blend-multiply"></div>
        <div class="absolute bottom-0 left-0 p-20 text-white z-20">
             <blockquote class="text-2xl font-medium">
                "Jelajahi keindahan dunia dan temukan kedamaian dalam setiap langkah perjalanan Anda."
            </blockquote>
             <p class="mt-4 font-semibold">- IslamicAdventure Team</p>
        </div>
    </div>
</div>