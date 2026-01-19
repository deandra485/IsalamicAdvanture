<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6 lg:p-8">
    
    {{-- Header & Controls --}}
    <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Analytics Dashboard</h1>
            <p class="mt-2 text-sm text-slate-500">Real-time performance overview & statistics</p>
        </div>

        {{-- Quick Date Filters --}}
        <div class="flex flex-wrap gap-2">
            <button wire:click="setToday" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                Today
            </button>
            <button wire:click="setThisWeek" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                This Week
            </button>
            <button wire:click="setThisMonth" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                This Month
            </button>
            <button wire:click="setLast30Days" class="rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100">
                Last 30 Days
            </button>
        </div>
    </div>

    {{-- Filter Toolbar --}}
    <div class="mb-8 flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between" wire:loading.class="opacity-50">
        <div class="flex flex-col sm:flex-row gap-3 flex-1">
            <div class="relative">
                <input type="date" wire:model.live="startDate" class="block w-full rounded-lg border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                <label class="absolute -top-2 left-2 bg-white px-1 text-[10px] font-semibold text-slate-400">Start Date</label>
            </div>
            <div class="relative">
                <input type="date" wire:model.live="endDate" class="block w-full rounded-lg border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                <label class="absolute -top-2 left-2 bg-white px-1 text-[10px] font-semibold text-slate-400">End Date</label>
            </div>

            <select wire:model.live="period" class="block rounded-lg border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2 pr-8">
                <option value="daily">Daily View</option>
                <option value="monthly">Monthly View</option>
            </select>
        </div>

        <button wire:click="exportCsv" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Export CSV</span>
        </button>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="mb-4 rounded-lg bg-indigo-50 border border-indigo-200 px-4 py-3 text-sm text-indigo-700">
        <div class="flex items-center gap-2">
            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Updating data...
        </div>
    </div>

    {{-- Stats Cards Row 1 --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        {{-- Total Revenue with Trend --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <dt>
                <div class="absolute rounded-md bg-indigo-50 p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Total Revenue</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1">
                <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($this->totalRevenue, 0, ',', '.') }}</p>
            </dd>
            @if(isset($revenueComparison))
            <dd class="ml-16 flex items-center gap-1 text-xs">
                @if($revenueComparison['trend'] === 'up')
                    <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span class="font-medium text-emerald-600">+{{ $revenueComparison['change'] }}%</span>
                @else
                    <svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                    <span class="font-medium text-red-600">{{ $revenueComparison['change'] }}%</span>
                @endif
                <span class="text-slate-400">vs previous period</span>
            </dd>
            @endif
        </div>

        {{-- Confirmed Bookings --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <dt>
                <div class="absolute rounded-md bg-purple-50 p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Total Bookings</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1">
                <p class="text-2xl font-bold text-slate-900">{{ $this->totalBookings }}</p>
                <span class="ml-2 text-xs text-slate-400">confirmed</span>
            </dd>
        </div>

        {{-- New Customers --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <dt>
                <div class="absolute rounded-md bg-emerald-50 p-3">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">New Customers</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1">
                <p class="text-2xl font-bold text-slate-900">{{ $this->newCustomers }}</p>
                <span class="ml-2 text-xs text-slate-400">registered</span>
            </dd>
        </div>

        {{-- Average Booking Value --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <dt>
                <div class="absolute rounded-md bg-orange-50 p-3">
                    <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Avg. Booking Value</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1">
                <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($this->averageBookingValue, 0, ',', '.') }}</p>
            </dd>
        </div>
    </div>

    {{-- Stats Cards Row 2 --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-8">
        {{-- Completion Rate --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Completion Rate</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $this->completionRate }}%</p>
                </div>
                <div class="rounded-full bg-blue-50 p-3">
                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $this->completionRate }}%"></div>
            </div>
        </div>

        {{-- Pending Payments --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pending Payments</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">Rp {{ number_format($this->pendingPayments, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-400 mt-1">Awaiting verification</p>
                </div>
                <div class="rounded-full bg-amber-50 p-3">
                    <svg class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Chart Section --}}
    <div class="mb-8 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-5 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Revenue Trend</h3>
                <p class="text-sm text-slate-500 mt-1">Daily revenue performance over time</p>
            </div>
            <div class="flex gap-2">
                <span class="inline-flex items-center gap-2 rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700">
                    <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                    Revenue
                </span>
            </div>
        </div>
        <div class="p-6">
            <div 
                x-data="{
                    chart: null,
                    init() {
                        let data = @js($revenueChart);
                        
                        let options = {
                            series: [{
                                name: 'Revenue',
                                data: data.map(item => item.total)
                            }],
                            chart: {
                                type: 'area',
                                height: 380,
                                fontFamily: 'inherit',
                                toolbar: { 
                                    show: true,
                                    tools: {
                                        download: true,
                                        zoom: true,
                                        zoomin: true,
                                        zoomout: true,
                                        pan: true,
                                        reset: true
                                    }
                                },
                                animations: {
                                    enabled: true,
                                    speed: 800
                                }
                            },
                            dataLabels: { enabled: false },
                            stroke: { curve: 'smooth', width: 3 },
                            xaxis: {
                                categories: data.map(item => item.date),
                                labels: { 
                                    style: { colors: '#64748b', fontSize: '12px' },
                                    rotate: -45
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: { colors: '#64748b', fontSize: '12px' },
                                    formatter: (value) => { 
                                        return new Intl.NumberFormat('id-ID', { 
                                            style: 'currency', 
                                            currency: 'IDR', 
                                            maximumSignificantDigits: 3 
                                        }).format(value);
                                    }
                                }
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.5,
                                    opacityTo: 0.1,
                                    stops: [0, 90, 100]
                                }
                            },
                            colors: ['#4f46e5'],
                            grid: {
                                borderColor: '#f1f5f9',
                                strokeDashArray: 4
                            },
                            tooltip: {
                                theme: 'light',
                                y: { 
                                    formatter: function (val) { 
                                        return val.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                                    } 
                                }
                            }
                        };

                        if (this.chart) {
                            this.chart.destroy();
                        }
                        
                        this.chart = new ApexCharts(this.$refs.chartContainer, options);
                        this.chart.render();
                    }
                }"
                wire:key="revenue-chart-{{ $period }}"
            >
                <div x-ref="chartContainer"></div>
            </div>
        </div>
    </div>

    {{-- Bottom Section: Leaderboards & Status --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 mb-8">
        
        {{-- Top Mountains --}}
        <div class="lg:col-span-1 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-900">Top Destinations</h3>
                <span class="text-xs font-medium text-slate-500">Bookings</span>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-slate-100">
                    @forelse($topMountains as $name => $stats)
                        <li class="flex items-center justify-between px-6 py-4 transition hover:bg-slate-50">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-700 truncate">{{ $name }}</p>
                                    <p class="text-xs text-slate-400">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-slate-900 ml-2">{{ $stats['count'] }}</span>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center text-sm text-slate-500">No data available</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Top Equipment --}}
        <div class="lg:col-span-1 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-900">Popular Equipment</h3>
                <span class="text-xs font-medium text-slate-500">Usage</span>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-slate-100">
                    @forelse($topEquipment as $eq)
                        <li class="flex items-center justify-between px-6 py-4 transition hover:bg-slate-50">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="rounded-lg bg-orange-50 p-2 flex-shrink-0">
                                    <svg class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-700 truncate">{{ $eq['name'] }}</p>
                                    <p class="text-xs text-slate-400">{{ $eq['category'] }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800 ml-2">
                                {{ $eq['total_usage'] }}
                            </span>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center text-sm text-slate-500">No data available</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Booking Status Breakdown --}}
        <div class="lg:col-span-1 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-900">Booking Status</h3>
            </div>
            <div class="p-6 space-y-4">
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-800',
                        'confirmed' => 'bg-blue-100 text-blue-800',
                        'ongoing' => 'bg-indigo-100 text-indigo-800',
                        'completed' => 'bg-emerald-100 text-emerald-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $totalStatuses = array_sum($bookingsByStatus->toArray());
                @endphp
                
                @foreach($bookingsByStatus as $status => $count)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="{{ $statusColors[$status] ?? 'bg-slate-500' }} h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $totalStatuses > 0 ? ($count / $totalStatuses) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Payment Methods Breakdown --}}
    @if($paymentMethods->isNotEmpty())
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h3 class="font-semibold text-slate-900">Payment Methods Distribution</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($paymentMethods as $method)
                    @php
                        $methodIcons = [
                            'transfer_bank' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />',
                            'e_wallet' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />',
                            'cod' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />',
                        ];
                    @endphp
                    <div class="rounded-xl border border-slate-200 p-4 hover:shadow-md transition">
                        <div class="flex items-start gap-3">
                            <div class="rounded-lg bg-indigo-50 p-2">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $methodIcons[$method->metode_pembayaran] ?? '' !!}
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $method->metode_pembayaran) }}</p>
                                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $method->count }}</p>
                                <p class="text-xs text-slate-500 mt-1">Rp {{ number_format($method->total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush