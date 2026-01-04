<div class="min-h-screen bg-gray-50/50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h1>
            <p class="mt-2 text-sm text-gray-500">Kelola informasi pribadi dan preferensi keamanan Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-3">
                <nav class="space-y-2 sticky top-6">
                    <button wire:click="$set('activeTab', 'profile')"
                            class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ $activeTab === 'profile' ? 'bg-white text-blue-600 shadow-md shadow-blue-500/5 ring-1 ring-black/5' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
                        <span class="p-2 mr-3 rounded-lg {{ $activeTab === 'profile' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:text-gray-700' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        <span>Informasi Profile</span>
                        @if($activeTab === 'profile')
                            <svg class="w-5 h-5 ml-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        @endif
                    </button>

                    <button wire:click="$set('activeTab', 'password')"
                            class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ $activeTab === 'password' ? 'bg-white text-blue-600 shadow-md shadow-blue-500/5 ring-1 ring-black/5' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
                        <span class="p-2 mr-3 rounded-lg {{ $activeTab === 'password' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:text-gray-700' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <span>Keamanan</span>
                        @if($activeTab === 'password')
                            <svg class="w-5 h-5 ml-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        @endif
                    </button>
                </nav>
            </div>

            <div class="lg:col-span-9 space-y-6">
                
                @if (session()->has('success') || session()->has('password_success'))
                    <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 flex items-center animate-fade-in-down">
                        <div class="flex-shrink-0 bg-emerald-100 rounded-full p-1">
                            <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <p class="ml-3 text-sm font-medium text-emerald-800">{{ session('success') ?? session('password_success') }}</p>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="bg-rose-50 border border-rose-100 rounded-xl p-4 flex items-center animate-fade-in-down">
                        <div class="flex-shrink-0 bg-rose-100 rounded-full p-1">
                            <svg class="h-5 w-5 text-rose-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                        <p class="ml-3 text-sm font-medium text-rose-800">{{ session('error') }}</p>
                    </div>
                @endif

                @if($activeTab === 'profile')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <form wire:submit="updateProfile">
                        <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                            <div class="flex flex-col sm:flex-row items-center gap-6">
                                <div class="relative group">
                                    <div class="relative w-28 h-28 rounded-full overflow-hidden ring-4 ring-white shadow-lg">
                                        @if($existingAvatar)
                                            <img src="{{ Storage::url($existingAvatar) }}" class="w-full h-full object-cover" alt="Avatar">
                                        @elseif($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-4xl font-bold">
                                                {{ substr(auth()->user()->name, 0, 1) }}
                                            </div>
                                        @endif
                                        
                                        <div wire:loading wire:target="avatar" class="absolute inset-0 bg-black/40 flex items-center justify-center z-20">
                                            <svg class="animate-spin h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </div>
                                    </div>
                                    
                                    <label for="avatar-upload" class="absolute bottom-1 right-1 bg-white p-2 rounded-full shadow-md cursor-pointer hover:bg-gray-50 border border-gray-200 transition-colors z-10">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </label>
                                    <input type="file" id="avatar-upload" wire:model="avatar" accept="image/*" class="hidden">
                                </div>

                                <div class="text-center sm:text-left space-y-2">
                                    <h3 class="text-lg font-bold text-gray-900">Foto Profile</h3>
                                    <p class="text-sm text-gray-500 max-w-xs">Format JPG, PNG atau GIF. Maksimal ukuran file 2MB.</p>
                                    
                                    @if($existingAvatar)
                                        <button type="button" wire:click="removeAvatar" wire:confirm="Hapus foto profile ini?" class="text-sm text-rose-600 font-medium hover:text-rose-700 hover:underline">
                                            Hapus foto saat ini
                                        </button>
                                    @endif
                                    @error('avatar') <p class="text-sm text-rose-600 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                    <input type="text" wire:model="name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 transition-all" placeholder="John Doe">
                                    @error('name') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                        </div>
                                        <input type="email" wire:model="email" class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 transition-all" placeholder="name@company.com">
                                    </div>
                                    @error('email') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Nomor Telepon</label>
                                    <input type="text" wire:model="no_telepon" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5 transition-all" placeholder="+62 812...">
                                    @error('no_telepon') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Role Akun</label>
                                    <input type="text" value="{{ ucfirst(auth()->user()->role) }}" disabled class="block w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500 shadow-sm sm:text-sm py-2.5 cursor-not-allowed">
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                                <textarea wire:model="alamat" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-all" placeholder="Masukkan alamat lengkap..."></textarea>
                                @error('alamat') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                Batal
                            </a>
                            <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-wait transition-all">
                                <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                                <span wire:loading wire:target="updateProfile" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                @if($activeTab === 'password')
                <div class="grid grid-cols-1 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-8 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Ubah Password</h3>
                            <p class="mt-1 text-sm text-gray-500">Buat password yang kuat untuk menjaga keamanan akun Anda.</p>
                        </div>

                        <form wire:submit="updatePassword" class="p-8 space-y-6">
                            <div class="max-w-xl space-y-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Password Saat Ini</label>
                                    <input type="password" wire:model="current_password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                                    @error('current_password') <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Password Baru</label>
                                    <input type="password" wire:model="new_password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                                    <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter, kombinasi huruf & angka.</p>
                                    @error('new_password') <span class="text-xs text-rose-600 block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                                    <input type="password" wire:model="new_password_confirmation" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2.5">
                                </div>
                            </div>
                            
                            <div class="pt-4 flex items-center justify-start border-t border-gray-100 mt-6">
                                <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-wait transition-all">
                                    <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                                    <span wire:loading wire:target="updatePassword" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Memproses...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-6 border border-blue-100/50">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-2 bg-white rounded-lg shadow-sm text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Rekomendasi Keamanan</h4>
                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Gunakan minimal 8 karakter
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Kombinasi simbol & angka
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Hindari data pribadi (Ultah)
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Ubah berkala (tiap 3 bulan)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>