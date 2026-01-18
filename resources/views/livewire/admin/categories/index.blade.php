<div class="min-h-screen bg-gray-50/50 p-6">
    {{-- Header Section --}}
    <div class="mb-8 sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Categories</h1>
            <p class="mt-2 text-sm text-slate-500">Manage and organize your equipment categories efficiently.</p>
        </div>
        <div class="mt-4 sm:mt-0">
             <button 
                wire:click="toggleForm"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                @if($showForm)
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close Form
                @else
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Category
                @endif
            </button>
        </div>
    </div>

    {{-- Alerts --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 flex items-center justify-between rounded-xl border border-green-100 bg-green-50 p-4 text-green-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 ring-4 ring-green-50">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 flex items-center justify-between rounded-xl border border-red-100 bg-red-50 p-4 text-red-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 ring-4 ring-red-50">
                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-700">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Create/Edit Form Card --}}
    <div 
        x-show="$wire.showForm" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="mb-8 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
    >
        <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
            <h3 class="font-semibold text-slate-800">Create New Category</h3>
        </div>
        <div class="p-6">
            <form wire:submit.prevent="save">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Category Name</label>
                        <input 
                            type="text" 
                            id="name"
                            wire:model="name"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder:text-slate-400"
                            placeholder="e.g., Heavy Machinery, Electronics"
                        >
                        @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <textarea 
                            id="description"
                            wire:model="description"
                            rows="3"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder:text-slate-400"
                            placeholder="Briefly describe what belongs in this category..."
                        ></textarea>
                        @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-4">
                    <button 
                        type="button"
                        wire:click="toggleForm"
                        class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        {{-- Toolbar --}}
        <div class="border-b border-slate-200 bg-white p-4 sm:px-6">
            <div class="relative max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    class="block w-full rounded-lg border-slate-300 bg-slate-50 pl-10 leading-5 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm"
                    placeholder="Search categories by name..."
                >
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Equipment
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($categories as $category)
                        <tr class="transition-colors hover:bg-slate-50/50">
                            @if ($editingId === $category->id)
                                {{-- Inline Editing State --}}
                                <td class="px-6 py-4 align-top">
                                    <input 
                                        type="text" 
                                        wire:model="editName"
                                        class="block w-full rounded-md border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                    @error('editName') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <textarea 
                                        wire:model="editDescription"
                                        rows="2"
                                        class="block w-full rounded-md border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    ></textarea>
                                    @error('editDescription') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </td>
                                <td class="px-6 py-4 text-center align-top">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                                        {{ $category->equipment_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right align-top">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="update" class="rounded p-1 text-green-600 hover:bg-green-50" title="Save">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <button wire:click="cancelEdit" class="rounded p-1 text-slate-500 hover:bg-slate-100" title="Cancel">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </td>
                            @else
                                {{-- Normal View State --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 font-bold uppercase">
                                            {{ substr($category->nama_kategori, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-slate-900">{{ $category->nama_kategori }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs truncate text-sm text-slate-500">
                                        {{ $category->deskripsi ?: 'No description provided' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                                        {{ $category->equipment_count }} items
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-3">
                                        <button 
                                            wire:click="edit({{ $category->id }})"
                                            class="text-slate-400 transition-colors hover:text-indigo-600"
                                            title="Edit"
                                        >
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <button 
                                            wire:click="$dispatch('confirm-delete', { id: {{ $category->id }}, name: '{{ $category->nama_kategori }}' })"
                                            class="text-slate-400 transition-colors hover:text-red-600 disabled:opacity-30 disabled:hover:text-slate-400"
                                            @if($category->equipment_count > 0) disabled title="Cannot delete category with equipment" @else title="Delete" @endif
                                        >
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                    <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <h3 class="mt-2 text-sm font-semibold text-slate-900">No categories found</h3>
                                <p class="mt-1 text-sm text-slate-500">Get started by creating a new category.</p>
                                <button 
                                    wire:click="toggleForm"
                                    class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500"
                                >
                                    Create new category &rarr;
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-4 py-3 sm:px-6">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('confirm-delete', (event) => {
            // Event detail mungkin datang dalam bentuk array atau object tergantung versi Livewire
            // Kita akses properties secara aman
            const data = event[0] || event;
            
            if (confirm(`Are you sure you want to delete "${data.name}"? This action cannot be undone.`)) {
                Livewire.dispatch('confirm-delete', { id: data.id });
            }
        });
    });
</script>
@endpush