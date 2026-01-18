<div class="min-h-screen bg-gray-50/50 p-6 lg:p-8">
    {{-- Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Reviews Management</h1>
            <p class="mt-2 text-sm text-slate-500">
                Monitor customer feedback, ratings, and moderate user comments.
            </p>
        </div>
        
        {{-- Optional: Quick Stats (Hardcoded example for layout visuals) --}}
        <div class="flex gap-4">
            <div class="hidden sm:block rounded-lg bg-white px-4 py-2 border border-slate-200 text-center shadow-sm">
                <span class="block text-xs font-medium text-slate-500 uppercase">Total Reviews</span>
                <span class="block text-lg font-bold text-slate-900">{{ $reviews->total() }}</span>
            </div>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 rounded-xl border border-green-100 bg-green-50 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1 text-sm font-medium text-green-800">{{ session('success') }}</div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Main Card --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm ring-1 ring-slate-900/5">
        
        {{-- Toolbar --}}
        <div class="border-b border-slate-100 px-6 py-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                {{-- Search --}}
                <div class="relative max-w-md w-full">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search comment, user, or mountain..." 
                        class="block w-full rounded-lg border-slate-300 bg-slate-50 pl-10 leading-relaxed placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm py-2.5 transition-colors"
                    >
                </div>

                {{-- Filter --}}
                <div class="w-full sm:w-48">
                    <div class="relative">
                        <select 
                            wire:model.live="statusFilter" 
                            class="block w-full appearance-none rounded-lg border-slate-300 bg-slate-50 py-2.5 pl-3 pr-10 text-sm focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                        >
                            <option value="all">All Status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">User Details</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Rating</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 w-1/3">Comment</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white" wire:loading.class="opacity-50">
                        @forelse($reviews as $review)
                            <tr class="group transition-colors hover:bg-slate-50">
                                {{-- User Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white" 
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name ?? 'User') }}&color=6366f1&background=e0e7ff&bold=true" 
                                                 alt="{{ $review->user->name ?? 'User' }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-slate-900">{{ $review->user->name ?? 'Unknown User' }}</div>
                                            <div class="flex items-center gap-1 text-xs text-slate-500 mt-0.5">
                                                <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $review->mountain->nama_gunung ?? 'Deleted Mountain' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Rating --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                            <span class="ml-2 text-xs font-semibold text-slate-600">{{ $review->rating }}.0</span>
                                        </div>
                                        <span class="text-[10px] text-slate-400">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                </td>

                                {{-- Comment --}}
                                <td class="px-6 py-4">
                                    <div class="relative">
                                        <svg class="absolute -top-2 -left-2 h-4 w-4 text-slate-200 transform -scale-x-100" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 13.1216 16 12.017 16H9C9.00001 15 9.00001 15 9 15C9 14.5055 9.17647 12.5966 11.0169 11.2023L11.6231 10.743L11.0269 10.0216C10.7062 9.63375 10.5284 9.13524 10.5284 8.63155C10.5284 7.63391 11.2366 6.77976 12.2139 6.59275L12.7844 6.48358L12.2139 6.48358C11.9774 6.48358 11.7766 6.33129 11.6966 6.11145L11.6966 6.11146C11.6966 6.11146 11.6933 6.10237 11.6865 6.08447C11.6192 5.90807 11.8385 5.76077 12.0232 5.86475C12.3392 6.04258 12.6989 6.14286 13.0857 6.14286C14.6953 6.14286 16 4.83815 16 3.22857C16 1.44554 14.5545 0 12.7714 0H8.22857C3.68411 0 0 3.68411 0 8.22857V12.7714C0 17.3159 3.68411 21 8.22857 21H12.7714C13.4597 21 14.017 20.4427 14.017 19.7544V21Z"/></svg>
                                        <p class="text-sm text-slate-600 line-clamp-2 pl-3">
                                            {{ $review->komentar }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    @if($review->is_approved)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                            Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Toggle Status Button --}}
                                        <button 
                                            wire:click="toggleStatus({{ $review->id }})"
                                            title="{{ $review->is_approved ? 'Reject Review' : 'Approve Review' }}"
                                            class="rounded-lg p-2 transition-colors {{ $review->is_approved ? 'text-amber-500 hover:bg-amber-50' : 'text-emerald-500 hover:bg-emerald-50' }}"
                                        >
                                            @if($review->is_approved)
                                                {{-- Icon: X (Reject) --}}
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            @else
                                                {{-- Icon: Check (Approve) --}}
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @endif
                                        </button>

                                        {{-- Delete Button --}}
                                        <button 
                                            wire:click="delete({{ $review->id }})"
                                            wire:confirm="Are you sure you want to permanently delete this review?"
                                            title="Delete Review"
                                            class="rounded-lg p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors"
                                        >
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-2 text-sm font-semibold text-slate-900">No reviews found</h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        No reviews match your search or filter criteria.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer / Pagination --}}
        @if($reviews->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-4 py-3 sm:px-6">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>