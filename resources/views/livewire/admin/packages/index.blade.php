<div class="min-h-screen bg-gray-50/50 p-6 lg:p-8">
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Packages Management</h1>
            <p class="mt-2 text-sm text-slate-500">
                Manage your hiking adventures, pricing, and equipment bundles.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.packages.create') }}" 
               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Package
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 rounded-xl border border-green-100 bg-green-50 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Content Card --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        {{-- Toolbar / Search --}}
        <div class="border-b border-slate-100 px-6 py-5">
            <div class="relative max-w-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    class="block w-full rounded-lg border-slate-300 bg-slate-50 pl-10 leading-relaxed placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm py-2.5"
                    placeholder="Search by package name or mountain..." 
                >
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Package Details</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Price & Specs</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Capacity</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($packages as $package)
                        <tr class="group transition-colors hover:bg-slate-50">
                            {{-- Column: Package Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-4">
                                    {{-- Visual Icon Placeholder --}}
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $package->nama_paket }}</div>
                                        <div class="flex items-center gap-1 text-sm text-slate-500">
                                            <span>via {{ $package->mountain->nama_gunung ?? 'Unknown Mountain' }}</span>
                                        </div>
                                        <div class="mt-1 line-clamp-1 text-xs text-slate-400">
                                            {{ $package->deskripsi }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Column: Price & Duration --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-900">
                                        Rp {{ number_format($package->harga_paket, 0, ',', '.') }}
                                    </span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                            <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $package->durasi_hari }} Days
                                        </span>
                                        @if($package->include_guide)
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                                Guide
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Column: Capacity --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-sm font-medium text-slate-700">{{ $package->max_peserta }} Pax</span>
                                    <span class="text-[10px] uppercase tracking-wide text-slate-400">Max Limit</span>
                                </div>
                            </td>

                            {{-- Column: Status --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                @if($package->is_active)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/20">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Column: Actions --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <div class="flex justify-end gap-2 opacity-0 transition-opacity group-hover:opacity-100">
                                    <a href="{{ route('admin.packages.edit', $package->id) }}" 
                                       class="rounded p-2 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors" 
                                       title="Edit Package">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    <button 
                                        wire:click="delete({{ $package->id }})" 
                                        wire:confirm="Are you sure you want to delete this package?"
                                        class="rounded p-2 text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors"
                                        title="Delete Package">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="mt-2 text-sm font-semibold text-slate-900">No packages found</h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    No hiking packages match your search criteria.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($packages->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-4 py-3 sm:px-6">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</div>