<div class="min-h-screen bg-slate-50 py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Payment Management</h1>
                <p class="mt-1 text-sm text-slate-500">Monitor transaksi, verifikasi pembayaran, dan kelola arus kas.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button wire:click="resetFilters" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset Filter
                </button>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session()->has('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 p-4 border border-emerald-100 flex items-start shadow-sm">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 rounded-lg bg-rose-50 p-4 border border-rose-100 flex items-start shadow-sm">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-rose-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pending</p>
                        <h3 class="mt-2 text-2xl font-bold text-slate-800 group-hover:text-amber-600 transition-colors">{{ $this->stats['pending'] }}</h3>
                    </div>
                    <div class="p-2 bg-amber-50 rounded-lg group-hover:bg-amber-100 transition-colors">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Verified (Bln)</p>
                        <h3 class="mt-2 text-2xl font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $this->stats['verified'] }}</h3>
                    </div>
                    <div class="p-2 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Rejected (Bln)</p>
                        <h3 class="mt-2 text-2xl font-bold text-slate-800 group-hover:text-rose-600 transition-colors">{{ $this->stats['rejected'] }}</h3>
                    </div>
                    <div class="p-2 bg-rose-50 rounded-lg group-hover:bg-rose-100 transition-colors">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>

             <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Verified Hari Ini</p>
                        <h3 class="mt-2 text-2xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $this->stats['today_verified'] }}</h3>
                    </div>
                    <div class="p-2 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-xl p-5 shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all duration-200 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-indigo-100 uppercase tracking-wider">Total (Bln)</p>
                        <h3 class="mt-2 text-xl font-bold text-white">Rp {{ number_format($this->stats['total_amount'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            
            {{-- Tabs & Filters Container --}}
            <div class="border-b border-slate-200 bg-slate-50/50 p-4 sm:p-6 space-y-6">
                
                {{-- Modern Segmented Tabs --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <nav class="flex p-1 space-x-1 bg-slate-100 rounded-xl max-w-fit" aria-label="Tabs">
                        @foreach(['all' => 'Semua', 'pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Rejected'] as $key => $label)
                            <button wire:click="setStatus('{{ $key }}')"
                                class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out
                                {{ $status === $key 
                                    ? 'bg-white text-slate-900 shadow-sm ring-1 ring-slate-200' 
                                    : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                                {{ $label }}
                                @if($key === 'pending' && $this->stats['pending'] > 0)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ $this->stats['pending'] }}
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </nav>
                </div>

                {{-- Filters --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Search --}}
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               class="block w-full pl-10 pr-3 py-2.5 border-slate-200 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm transition-all"
                               placeholder="Cari booking, nama, email...">
                    </div>

                    {{-- Quick Range --}}
                    <div>
                        <select wire:change="setDateRange($event.target.value)" 
                                class="block w-full py-2.5 px-3 border-slate-200 rounded-lg text-sm text-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm cursor-pointer">
                            <option value="">Pilih Rentang Waktu...</option>
                            <option value="today">📅 Hari Ini</option>
                            <option value="week">📅 7 Hari Terakhir</option>
                            <option value="month">📅 30 Hari Terakhir</option>
                            <option value="year">📅 1 Tahun Terakhir</option>
                        </select>
                    </div>

                    {{-- Date From --}}
                    <div>
                        <input type="date" 
                               wire:model.live="dateFrom" 
                               class="block w-full py-2.5 px-3 border-slate-200 rounded-lg text-sm text-slate-600 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm">
                    </div>

                    {{-- Date To --}}
                    <div>
                        <input type="date" 
                               wire:model.live="dateTo" 
                               class="block w-full py-2.5 px-3 border-slate-200 rounded-lg text-sm text-slate-600 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm">
                    </div>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" wire:click="sortBy('tanggal_pembayaran')" 
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition-colors group">
                                <div class="flex items-center gap-1">
                                    Tanggal
                                    <span class="text-slate-400 group-hover:text-indigo-500">
                                        @if($sortBy === 'tanggal_pembayaran')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @else
                                            ↕
                                        @endif
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Booking Info
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col" wire:click="sortBy('jumlah_bayar')" 
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition-colors group">
                                <div class="flex items-center gap-1">
                                    Jumlah
                                    <span class="text-slate-400 group-hover:text-indigo-500">
                                        @if($sortBy === 'jumlah_bayar')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @else
                                            ↕
                                        @endif
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Metode
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($this->payments as $payment)
                            <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-slate-900">{{ $payment->tanggal_pembayaran->format('d M Y') }}</span>
                                        <span class="text-xs text-slate-500 font-mono">{{ $payment->tanggal_pembayaran->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-indigo-600 font-mono tracking-tight">{{ $payment->booking->kode_booking }}</span>
                                        <span class="text-xs text-slate-500 capitalize">{{ $payment->booking->booking_type }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-indigo-100 to-purple-100 border border-white shadow-sm flex items-center justify-center">
                                                <span class="text-indigo-700 font-bold text-xs">{{ substr($payment->booking->user->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-slate-900">{{ $payment->booking->user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $payment->booking->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-700 font-mono">
                                        Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 capitalize border border-slate-200">
                                        {{ $payment->metode_pembayaran }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->status_pembayaran === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200/60 ring-1 ring-amber-500/10">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                            Pending
                                        </span>
                                    @elseif($payment->status_pembayaran === 'verified')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60 ring-1 ring-emerald-500/10">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200/60 ring-1 ring-rose-500/10">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    {{-- Uncomment dan sesuaikan link detail --}}
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                       wire:navigate
                                       class="text-slate-400 hover:text-indigo-600 transition-colors p-2 rounded-full hover:bg-indigo-50 inline-flex" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    
                                    <button class="text-slate-400 hover:text-indigo-600 font-medium text-xs border border-transparent hover:border-indigo-100 hover:bg-indigo-50 px-3 py-1 rounded-lg transition-all">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-slate-50 rounded-full p-4 mb-4">
                                            <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-900">Data tidak ditemukan</h3>
                                        <p class="mt-1 text-sm text-slate-500 max-w-sm">
                                            Tidak ada pembayaran yang sesuai dengan kriteria pencarian atau filter yang Anda pilih.
                                        </p>
                                        <button wire:click="resetFilters" class="mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium hover:underline">
                                            Reset Filter
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($this->payments->hasPages())
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                    {{ $this->payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>