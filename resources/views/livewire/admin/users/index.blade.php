<div class="min-h-screen bg-slate-50/50 p-6 md:p-8">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Users Management</h1>
            <p class="mt-1 text-sm text-slate-500">View permissions, track bookings, and manage access.</p>
        </div>
        {{-- Bisa tambahkan tombol 'Add User' disini jika ada fiturnya --}}
    </div>

    {{-- Alert / Toast --}}
    @if (session()->has('success'))
        <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow-sm" role="alert">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Main Content Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm ring-1 ring-slate-900/5">
        
        {{-- Toolbar (Search & Filter) --}}
        <div class="border-b border-slate-100 bg-white px-6 py-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                {{-- Search Input with Icon --}}
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        class="block w-full rounded-lg border-0 bg-slate-50 py-2.5 pl-10 pr-3 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        placeholder="Search users by name or email..."
                    >
                </div>
                
                {{-- Role Filter --}}
                <div class="sm:w-48">
                    <div class="relative">
                        <select wire:model.live="roleFilter" class="block w-full cursor-pointer appearance-none rounded-lg border-0 bg-slate-50 py-2.5 pl-3 pr-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">User Profile</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Contact</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Role Access</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Account Status</th>
                        <th scope="col" class="relative px-6 py-4"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($users as $user)
                        <tr wire:key="user-row-{{ $user->id }}" class="group transition-colors hover:bg-slate-50/80">
                            
                            {{-- User Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 font-bold ring-2 ring-white shadow-sm">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        <div class="mt-0.5 flex items-center text-[10px] text-slate-400">
                                            <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            Joined {{ $user->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $user->no_telepon ?? '-' }}
                            </td>

                            {{-- Role Selector (Styled as Badge) --}}
                            <td class="px-6 py-4">
                                <div class="relative inline-block w-32">
                                    <select 
                                        wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                        class="appearance-none block w-full rounded-full border-0 py-1.5 pl-3 pr-8 text-xs font-semibold ring-1 ring-inset focus:ring-2 focus:ring-indigo-600 cursor-pointer
                                        {{ $user->role === 'admin' 
                                            ? 'text-purple-700 ring-purple-600/20 bg-purple-50' 
                                            : 'text-slate-700 ring-slate-500/10 bg-slate-100' }}"
                                    >
                                        <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                                        <svg class="h-3 w-3 {{ $user->role === 'admin' ? 'text-purple-600' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </td>

                            {{-- Status Toggle --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <button 
                                        wire:click="toggleStatus({{ $user->id }})"
                                        class="group relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 {{ $user->is_active ? 'bg-emerald-500' : 'bg-slate-200' }}"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                    >
                                        <span class="sr-only">Toggle status</span>
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $user->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                    <span class="text-xs font-medium {{ $user->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="viewHistory({{ $user->id }})" class="rounded-lg p-2 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors" title="View Booking History">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    </button>
                                    <button wire:click="openPasswordModal({{ $user->id }})" class="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-colors" title="Reset Password">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                    <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                </div>
                                <h3 class="mt-2 text-sm font-semibold text-slate-900">No users found</h3>
                                <p class="mt-1 text-sm text-slate-500">Try adjusting your search or filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4">
            {{ $users->links() }}
        </div>
    </div>

    {{-- BOOKING MODAL --}}
    @if($showBookingModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 backdrop-blur-sm p-4 md:p-6">
            <div class="relative w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Booking History</h3>
                        <p class="text-xs text-slate-500">User: <span class="font-medium text-indigo-600">{{ $selectedUser->name }}</span></p>
                    </div>
                    <button wire:click="closeBookingModal" class="rounded-full p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="max-h-[60vh] overflow-y-auto bg-white">
                    @if($selectedUser && $selectedUser->bookings->count() > 0)
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Mountain Package</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-slate-500">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($selectedUser->bookings as $booking)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ $booking->mountain->nama_gunung ?? 'Unknown Package' }}</td>
                                        <td class="px-6 py-3 text-sm text-slate-500">{{ \Carbon\Carbon::parse($booking->tanggal_pendakian)->format('d M Y') }}</td>
                                        <td class="px-6 py-3 text-sm">
                                            @php
                                                $statusClasses = [
                                                    'confirmed' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                                    'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                                    'cancelled' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                                                ];
                                                $class = $statusClasses[$booking->status] ?? 'bg-slate-50 text-slate-700 ring-slate-600/20';
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $class }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-slate-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                            <svg class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            <p class="mt-2 text-sm">No booking history available.</p>
                        </div>
                    @endif
                </div>

                <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-right">
                    <button wire:click="closeBookingModal" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Close</button>
                </div>
            </div>
        </div>
    @endif

    {{-- PASSWORD RESET MODAL --}}
    @if($showPasswordModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
            <div class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                <div class="bg-rose-50 p-6 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-rose-900">Reset Password</h3>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <p class="text-sm text-slate-600">Enter a new password for <span class="font-semibold text-slate-900">{{ $selectedUser->name ?? 'User' }}</span>. This action cannot be undone.</p>
                    
                    <div class="mt-4">
                        <label class="block text-xs font-semibold uppercase text-slate-500">New Password</label>
                        <input type="text" wire:model="newPassword" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm" placeholder="e.g. secret123">
                        @error('newPassword') <span class="mt-1 block text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button wire:click="$set('showPasswordModal', false)" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                    <button wire:click="resetPassword" class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">Reset Password</button>
                </div>
            </div>
        </div>
    @endif

</div>