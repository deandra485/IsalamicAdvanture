<div class="min-h-screen bg-gray-50/50 p-6 lg:p-8">
    
    {{-- Header & Controls --}}
    <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Analytics Dashboard</h1>
            <p class="mt-2 text-sm text-slate-500">Performance overview & statistics</p>
        </div>

        {{-- Filter Toolbar --}}
        <div class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm sm:flex-row sm:items-center">
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="relative">
                    <input type="date" wire:model.live="startDate" class="block w-full rounded-lg border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                    <label class="absolute -top-2 left-2 bg-white px-1 text-[10px] font-semibold text-slate-400">Start</label>
                </div>
                <div class="relative">
                    <input type="date" wire:model.live="endDate" class="block w-full rounded-lg border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2">
                    <label class="absolute -top-2 left-2 bg-white px-1 text-[10px] font-semibold text-slate-400">End</label>
                </div>
            </div>

            <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

            <div class="flex items-center gap-2">
                <select wire:model.live="period" class="block rounded-lg border-slate-200 text-xs font-medium text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 py-2 pr-8">
                    <option value="daily">Daily View</option>
                    <option value="monthly">Monthly View</option>
                </select>
                
                <button wire:click="exportCsv" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span>Export</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        {{-- Total Revenue --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <dt>
                <div class="absolute rounded-md bg-indigo-50 p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Total Revenue</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </dd>
        </div>

        {{-- Confirmed Bookings --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <dt>
                <div class="absolute rounded-md bg-purple-50 p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Total Bookings</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-bold text-slate-900">{{ $totalBookings }}</p>
                <span class="ml-2 text-xs text-slate-400">trips confirmed</span>
            </dd>
        </div>

        {{-- New Customers --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <dt>
                <div class="absolute rounded-md bg-emerald-50 p-3">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">New Customers</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-bold text-slate-900">{{ $newCustomers }}</p>
                <span class="ml-2 text-xs text-slate-400">in this period</span>
            </dd>
        </div>
    </div>

    {{-- Main Chart Section --}}
    <div class="mb-8 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-5">
            <h3 class="text-lg font-semibold text-slate-900">Revenue Growth</h3>
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
                                height: 350,
                                fontFamily: 'inherit',
                                toolbar: { show: false }
                            },
                            dataLabels: { enabled: false },
                            stroke: { curve: 'smooth', width: 2 },
                            xaxis: {
                                categories: data.map(item => item.date),
                                labels: { style: { colors: '#64748b', fontSize: '12px' } }
                            },
                            yaxis: {
                                labels: {
                                    style: { colors: '#64748b', fontSize: '12px' },
                                    formatter: (value) => { 
                                        // FORMATTER AMAN (Tanpa Regex)
                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 3 }).format(value);
                                    }
                                }
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0.05,
                                    stops: [0, 90, 100]
                                }
                            },
                            colors: ['#4f46e5'],
                            tooltip: {
                                theme: 'light',
                                y: { 
                                    formatter: function (val) { 
                                        // FORMATTER AMAN (Tanpa Regex)
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
                class="w-full"
            >
                <div x-ref="chartContainer"></div>
            </div>
        </div>
    </div>

    {{-- Bottom Section: Leaderboards --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        
        {{-- Top Mountains --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-900">Popular Destinations</h3>
                <span class="text-xs font-medium text-slate-500">By bookings</span>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-slate-100">
                    @forelse($topMountains as $name => $count)
                        <li class="flex items-center justify-between px-6 py-4 transition hover:bg-slate-50">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600">
                                    {{ $loop->iteration }}
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ $name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-1.5 w-24 rounded-full bg-slate-100 overflow-hidden">
                                    {{-- PERBAIKAN: Math logic lebih aman --}}
                                    <div class="h-full bg-indigo-500" style="width: {{ $count > 50 ? '100' : ($count / 50) * 100 }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-900">{{ $count }} Trips</span>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center text-sm text-slate-500">No destination data available.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Top Equipment --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="font-semibold text-slate-900">Equipment Demand</h3>
                <span class="text-xs font-medium text-slate-500">Usage count</span>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-slate-100">
                    @forelse($topEquipment as $eq)
                        <li class="flex items-center justify-between px-6 py-4 transition hover:bg-slate-50">
                            <div class="flex items-center gap-3">
                                <div class="rounded-lg bg-orange-50 p-1.5">
                                    <svg class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ $eq['name'] }}</span>
                            </div>
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                                {{ $eq['total_usage'] }} units
                            </span>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center text-sm text-slate-500">No equipment usage data.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>