{{-- Hapus min-h-screen untuk menghilangkan double scroll --}}
<div class="w-full bg-slate-50/50 p-6 md:p-8">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Booking Overview</h1>
            <p class="mt-2 text-sm text-slate-500">Pantau performa bisnis dan kelola reservasi pelanggan.</p>
        </div>
        <div>
            <a href="{{ route('admin.bookings.pdf', ['date' => $dateFilter ?? now()->format('Y-m-d')]) }}" 
               target="_blank"
               class="group inline-flex items-center justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 transition-all hover:bg-slate-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                <svg class="mr-2 h-4 w-4 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Export Laporan Harian
            </a>
        </div>
    </div>

    {{-- Alert Notification --}}
    @if (session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-8 flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 ring-1 ring-emerald-200">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="rounded-lg p-1.5 text-emerald-600 hover:bg-emerald-100">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif

    {{-- Stats Grid --}}
    <div class="mb-8 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
        @php
            $statCards = [
                ['label' => 'Total', 'value' => $stats['total'], 'color' => 'slate', 'icon' => 'M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2'],
                ['label' => 'Pending', 'value' => $stats['pending'], 'color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Confirmed', 'value' => $stats['confirmed'], 'color' => 'indigo', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Ongoing', 'value' => $stats['ongoing'], 'color' => 'violet', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'emerald', 'icon' => 'M5 13l4 4L19 7'],
                ['label' => 'Cancelled', 'value' => $stats['cancelled'], 'color' => 'rose', 'icon' => 'M6 18L18 6M6 6l12 12'],
            ];
            
            $colors = [
                'slate' => 'bg-white border-slate-200 text-slate-600 ring-slate-100',
                'amber' => 'bg-amber-50/50 border-amber-200 text-amber-700 ring-amber-100',
                'indigo' => 'bg-indigo-50/50 border-indigo-200 text-indigo-700 ring-indigo-100',
                'violet' => 'bg-violet-50/50 border-violet-200 text-violet-700 ring-violet-100',
                'emerald' => 'bg-emerald-50/50 border-emerald-200 text-emerald-700 ring-emerald-100',
                'rose' => 'bg-rose-50/50 border-rose-200 text-rose-700 ring-rose-100',
            ];
        @endphp

        @foreach($statCards as $stat)
        <div class="relative overflow-hidden rounded-2xl border p-4 shadow-sm transition-all hover:shadow-md {{ $colors[$stat['color']] }}">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider opacity-70">{{ $stat['label'] }}</p>
                    <h3 class="mt-1 text-2xl font-bold">{{ $stat['value'] }}</h3>
                </div>
                <div class="rounded-lg p-2 bg-white/60 shadow-sm">
                    <svg class="h-5 w-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Main Content Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        
        {{-- Filters Bar --}}
        <div class="border-b border-slate-100 bg-white p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center">
                {{-- Search --}}
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.500ms="search"
                           class="block w-full rounded-xl border-0 bg-slate-50 py-2.5 pl-10 pr-3 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                           placeholder="Cari ID Booking atau Nama Customer...">
                </div>

                {{-- Filters Group --}}
                <div class="flex flex-col gap-3 sm:flex-row md:w-auto">
                    <div class="w-full sm:w-40">
                        <select wire:model.live="statusFilter" class="block w-full cursor-pointer rounded-xl border-0 bg-slate-50 py-2.5 pl-3 pr-8 text-sm text-slate-700 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-40">
                        <input type="date" 
                               wire:model.live="dateFilter"
                               class="block w-full cursor-pointer rounded-xl border-0 bg-slate-50 py-2.5 px-3 text-sm text-slate-700 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                    </div>

                    <div class="w-full sm:w-40">
                        <select wire:model.live="sortBy" class="block w-full cursor-pointer rounded-xl border-0 bg-slate-50 py-2.5 pl-3 pr-8 text-sm text-slate-700 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                            <option value="created_at">Terbaru</option>
                            <option value="tanggal_mulai">Tanggal Mulai</option>
                            <option value="total_biaya">Total Biaya</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Booking Ref</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Customer</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jadwal & Paket</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status Pembayaran</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status Booking</th>
                        <th scope="col" class="relative px-6 py-4"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($bookings as $booking)
                    <tr wire:key="booking-{{ $booking->id }}" class="group transition-colors hover:bg-slate-50">
                        
                        {{-- Booking Ref --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-mono text-sm font-bold text-indigo-600">#{{ $booking->id }}</span>
                                <span class="mt-0.5 text-xs text-slate-400">{{ $booking->created_at->diffForHumans() }}</span>
                            </div>
                        </td>

                        {{-- Customer --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 ring-2 ring-white">
                                    {{ substr($booking->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-slate-900">{{ $booking->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $booking->user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Jadwal --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900">
                                {{ $booking->tanggal_mulai?->format('d M Y') }}
                            </div>
                            <div class="mt-1 flex items-center gap-2 text-xs text-slate-500">
                                <span class="rounded bg-slate-100 px-1.5 py-0.5 font-medium text-slate-600 border border-slate-200">{{ $booking->durasi_hari }} Hari</span>
                                <span>&bull;</span>
                                <span>{{ $booking->items->count() }} Item</span>
                            </div>
                        </td>

                        {{-- Pembayaran --}}
                        <td class="px-6 py-4">
                            <div class="mb-1 text-sm font-bold text-slate-900">
                                Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}
                            </div>
                            @if($booking->payment)
                                @php
                                    $payStatus = $booking->payment->status_pembayaran;
                                    $payClasses = [
                                        'verified' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                        'failed' => 'bg-rose-50 text-rose-700 ring-rose-600/20'
                                    ];
                                    $class = $payClasses[$payStatus] ?? 'bg-slate-50 text-slate-700 ring-slate-600/20';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $class }}">
                                    @if($payStatus === 'verified')
                                        <svg class="mr-1 h-2 w-2 text-emerald-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                    @endif
                                    {{ ucfirst($payStatus) }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-500 ring-1 ring-inset ring-slate-500/10">
                                    Belum Bayar
                                </span>
                            @endif
                        </td>

                        {{-- Status Booking --}}
                        <td class="px-6 py-4">
                            <div class="relative w-36">
                                {{-- FIX: Gunakan wire:model.live untuk binding langsung --}}
                                <select 
                                    wire:key="status-{{ $booking->id }}"
                                    wire:model.live="statusChanges.{{ $booking->id }}"
                                    wire:change="updateStatus({{ $booking->id }})"
                                    class="appearance-none block w-full rounded-full border-0 py-1.5 pl-3 pr-8 text-xs font-bold shadow-sm ring-1 ring-inset cursor-pointer transition-colors
                                    {{ match($booking->status_booking) {
                                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                        'confirmed' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
                                        'ongoing' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
                                        'completed' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                        'cancelled' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                                        default => 'bg-slate-50 text-slate-700 ring-slate-600/20'
                                    } }}">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                
                                {{-- Indikator Loading --}}
                                <div wire:loading wire:target="updateStatus({{ $booking->id }})" class="absolute -right-6 top-2">
                                    <svg class="animate-spin h-4 w-4 text-indigo-600" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </div>
                            </div>
                        </td>

                        {{-- Action Button --}}
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.bookings.detail', $booking) }}" 
                               class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition-colors hover:bg-indigo-50 hover:text-indigo-600">
                                <span class="sr-only">Detail</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 ring-1 ring-slate-100">
                                <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-sm font-semibold text-slate-900">Tidak ada booking ditemukan</h3>
                            <p class="mt-1 text-sm text-slate-500">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>