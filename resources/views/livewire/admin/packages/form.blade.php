<div class="min-h-screen bg-gray-50/50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-5xl">
        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    {{ $package ? 'Edit Package' : 'Create New Package' }}
                </h1>
                <p class="mt-1 text-sm text-slate-500">Define package details, pricing, and equipment bundles.</p>
            </div>
            <a href="{{ route('admin.packages.index') }}" 
               class="group inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
                <svg class="h-4 w-4 text-slate-400 transition-colors group-hover:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        <form wire:submit.prevent="save" class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="p-6 lg:p-8">
                {{-- Section 1: Main Details --}}
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-semibold text-slate-900">Package Details</h3>
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        {{-- Package Name --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="nama_paket" class="mb-2 block text-sm font-medium text-slate-700">Package Name</label>
                            <input 
                                type="text" 
                                id="nama_paket"
                                wire:model="nama_paket" 
                                placeholder="e.g. 3 Days Rinjani Summit"
                                class="block w-full rounded-lg border-slate-300 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5"
                            >
                            @error('nama_paket') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Mountain Select --}}
                        <div class="col-span-1">
                            <label for="mountain_id" class="mb-2 block text-sm font-medium text-slate-700">Mountain Location</label>
                            <div class="relative">
                                <select 
                                    id="mountain_id"
                                    wire:model="mountain_id" 
                                    class="block w-full appearance-none rounded-lg border-slate-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5"
                                >
                                    <option value="">Select a Mountain</option>
                                    @foreach($mountains as $mount)
                                        <option value="{{ $mount->id }}">{{ $mount->nama_gunung }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('mountain_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Price --}}
                        <div class="col-span-1">
                            <label for="harga_paket" class="mb-2 block text-sm font-medium text-slate-700">Price</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-slate-500 sm:text-sm font-semibold">Rp</span>
                                </div>
                                <input 
                                    type="number" 
                                    id="harga_paket"
                                    wire:model="harga_paket" 
                                    class="block w-full rounded-lg border-slate-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" 
                                    placeholder="0"
                                >
                            </div>
                            @error('harga_paket') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Duration --}}
                        <div class="col-span-1">
                            <label for="durasi_hari" class="mb-2 block text-sm font-medium text-slate-700">Duration</label>
                            <div class="relative rounded-md shadow-sm">
                                <input 
                                    type="number" 
                                    id="durasi_hari"
                                    wire:model="durasi_hari" 
                                    min="1" 
                                    class="block w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 pr-12"
                                >
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-slate-500 sm:text-sm">Days</span>
                                </div>
                            </div>
                            @error('durasi_hari') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Max Participants --}}
                        <div class="col-span-1">
                            <label for="max_peserta" class="mb-2 block text-sm font-medium text-slate-700">Max Participants</label>
                            <div class="relative rounded-md shadow-sm">
                                <input 
                                    type="number" 
                                    id="max_peserta"
                                    wire:model="max_peserta" 
                                    min="1" 
                                    class="block w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 pr-12"
                                >
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-slate-500 sm:text-sm">Pax</span>
                                </div>
                            </div>
                            @error('max_peserta') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="col-span-1 md:col-span-2 lg:col-span-3">
                            <label for="deskripsi" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
                            <textarea 
                                id="deskripsi"
                                wire:model="deskripsi" 
                                rows="3" 
                                class="block w-full rounded-lg border-slate-300 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Describe the difficulty, highlights, and itinerary overview..."
                            ></textarea>
                            @error('deskripsi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Settings Toggles --}}
                <div class="mb-8 rounded-xl bg-slate-50 p-6 border border-slate-100">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-500">Configuration</h3>
                    <div class="flex flex-col gap-6 sm:flex-row sm:gap-12">
                        {{-- Toggle: Include Guide --}}
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-slate-900">Include Guide</span>
                                <span class="text-xs text-slate-500">Does this package come with a guide?</span>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" wire:model="include_guide" class="peer sr-only">
                                <div class="h-6 w-11 rounded-full bg-slate-200 after:absolute after:top-[2px] after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-indigo-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300/30"></div>
                            </label>
                        </div>

                        {{-- Toggle: Active Status --}}
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-slate-900">Active Status</span>
                                <span class="text-xs text-slate-500">Visible to customers</span>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" wire:model="is_active" class="peer sr-only">
                                <div class="h-6 w-11 rounded-full bg-slate-200 after:absolute after:top-[2px] after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300/30"></div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Equipment Bundle --}}
                <div>
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Included Equipment</h3>
                            <p class="text-xs text-slate-500">Add equipment that is included in this package price.</p>
                        </div>
                        <button 
                            type="button" 
                            wire:click="addItemRow" 
                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100 transition-colors"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Add Item
                        </button>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-4">
                        @if(empty($packageItems))
                            <div class="flex flex-col items-center justify-center py-8 text-center">
                                <div class="rounded-full bg-slate-100 p-3">
                                    <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <p class="mt-2 text-sm font-medium text-slate-900">No equipment added</p>
                                <p class="text-xs text-slate-500">Click "Add Item" to start bundling equipment.</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($packageItems as $index => $item)
                                    <div class="flex items-start gap-3 rounded-lg bg-white p-3 shadow-sm ring-1 ring-slate-200 sm:items-center">
                                        <div class="flex-1">
                                            <label class="sr-only">Equipment</label>
                                            <select 
                                                wire:model="packageItems.{{ $index }}.equipment_id" 
                                                class="block w-full rounded-md border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >
                                                <option value="">Select Equipment</option>
                                                @foreach($allEquipment as $eq)
                                                    <option value="{{ $eq->id }}">
                                                        {{ $eq->nama_barang }} (Available: {{ $eq->stok_tersedia }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("packageItems.{$index}.equipment_id") <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="w-24">
                                            <label class="sr-only">Quantity</label>
                                            <div class="relative">
                                                <input 
                                                    type="number" 
                                                    wire:model="packageItems.{{ $index }}.quantity" 
                                                    min="1" 
                                                    placeholder="Qty" 
                                                    class="block w-full rounded-md border-slate-300 text-center text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                >
                                            </div>
                                            @error("packageItems.{$index}.quantity") <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>

                                        <button 
                                            type="button" 
                                            wire:click="removeItemRow({{ $index }})" 
                                            class="rounded-md p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors"
                                            title="Remove item"
                                        >
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 rounded-b-2xl">
                <a href="{{ route('admin.packages.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg wire:loading wire:target="save" class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Save Package</span>
                </button>
            </div>
        </form>
    </div>
</div>