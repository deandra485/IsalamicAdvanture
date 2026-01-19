<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Booking;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layouts.admin')]
class Index extends Component
{
    public $startDate;
    public $endDate;
    public $period = 'daily'; // daily | monthly
    public $selectedMetric = 'revenue'; // revenue | bookings | customers
    public $refreshInterval = null; // Auto refresh feature

    public function mount()
    {
        // Default 30 hari terakhir
        $this->startDate = Carbon::now()->subDays(29)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    // Computed properties untuk performa lebih baik
    #[Computed]
    public function totalRevenue()
    {
        return $this->getBaseQuery()->sum('total_biaya');
    }

    #[Computed]
    public function totalBookings()
    {
        return $this->getBaseQuery()->count();
    }

    #[Computed]
    public function newCustomers()
    {
        return User::where('role', 'customer')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(), 
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->count();
    }

    #[Computed]
    public function averageBookingValue()
    {
        $total = $this->totalRevenue;
        $count = $this->totalBookings;
        return $count > 0 ? $total / $count : 0;
    }

    #[Computed]
    public function completionRate()
    {
        $total = Booking::whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])->count();
        $completed = Booking::where('status_booking', 'completed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->count();
        
        return $total > 0 ? round(($completed / $total) * 100, 1) : 0;
    }

    #[Computed]
    public function pendingPayments()
    {
        return Payment::where('status_pembayaran', 'pending')
            ->whereHas('booking', function($q) {
                $q->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate]);
            })
            ->sum('jumlah_bayar');
    }

    public function render()
    {
        return view('livewire.admin.reports.index', [
            'revenueChart'  => $this->getRevenueData(),
            'topMountains'  => $this->getTopMountains(),
            'topEquipment'  => $this->getTopEquipment(),
            'bookingsByStatus' => $this->getBookingsByStatus(),
            'paymentMethods' => $this->getPaymentMethodsBreakdown(),
            'revenueComparison' => $this->getRevenueComparison(),
        ]);
    }

    // --- Data Getters ---

    private function getBaseQuery()
    {
        return Booking::where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate]);
    }

    public function getRevenueData()
    {
        $format = $this->period === 'monthly' ? '%Y-%m' : '%Y-%m-%d';
        
        $data = Booking::where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->select(
                DB::raw("DATE_FORMAT(tanggal_mulai, '$format') as date"), 
                DB::raw('SUM(total_biaya) as total'), 
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(total_biaya) as average')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return $data->map(function ($item) {
            return [
                'date'  => $item->date,
                'total' => (int) $item->total,
                'count' => (int) $item->count,
                'average' => (int) $item->average,
            ];
        });
    }

    public function getTopMountains()
    {
        $bookings = Booking::with('package.mountain')
            ->where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->get();

        $stats = [];
        foreach ($bookings as $booking) {
            $namaGunung = $booking->package?->mountain?->nama_gunung ?? 'Unknown';
            
            if (!isset($stats[$namaGunung])) {
                $stats[$namaGunung] = [
                    'count' => 0,
                    'revenue' => 0
                ];
            }
            $stats[$namaGunung]['count']++;
            $stats[$namaGunung]['revenue'] += $booking->total_biaya;
        }

        // Sort by count
        uasort($stats, fn($a, $b) => $b['count'] <=> $a['count']);
        
        return array_slice($stats, 0, 5);
    }

    public function getTopEquipment()
    {
        $bookings = Booking::with(['package.equipment'])
            ->where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->get();

        $equipmentStats = [];

        foreach ($bookings as $booking) {
            if ($booking->package && $booking->package->equipment) {
                foreach ($booking->package->equipment as $eq) {
                    $qtyInPackage = $eq->pivot->quantity ?? 1;
                    
                    if (!isset($equipmentStats[$eq->id])) {
                        $equipmentStats[$eq->id] = [
                            'name' => $eq->nama_peralatan,
                            'total_usage' => 0,
                            'category' => $eq->category->nama_kategori ?? 'N/A'
                        ];
                    }
                    $equipmentStats[$eq->id]['total_usage'] += $qtyInPackage;
                }
            }
        }

        return collect($equipmentStats)->sortByDesc('total_usage')->take(5);
    }

    public function getBookingsByStatus()
    {
        return Booking::whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->select('status_booking', DB::raw('COUNT(*) as count'))
            ->groupBy('status_booking')
            ->get()
            ->mapWithKeys(fn($item) => [$item->status_booking => $item->count]);
    }

    public function getPaymentMethodsBreakdown()
    {
        return Payment::whereHas('booking', function($q) {
                $q->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate]);
            })
            ->where('status_pembayaran', 'verified')
            ->select('metode_pembayaran', DB::raw('COUNT(*) as count'), DB::raw('SUM(jumlah_bayar) as total'))
            ->groupBy('metode_pembayaran')
            ->get();
    }

    public function getRevenueComparison()
    {
        $currentTotal = $this->totalRevenue;
        
        // Get previous period
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $diff = $start->diffInDays($end);
        
        $previousStart = $start->copy()->subDays($diff + 1);
        $previousEnd = $start->copy()->subDay();
        
        $previousTotal = Booking::where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$previousStart->format('Y-m-d'), $previousEnd->format('Y-m-d')])
            ->sum('total_biaya');
        
        $percentageChange = $previousTotal > 0 
            ? round((($currentTotal - $previousTotal) / $previousTotal) * 100, 1)
            : 0;
        
        return [
            'current' => $currentTotal,
            'previous' => $previousTotal,
            'change' => $percentageChange,
            'trend' => $percentageChange >= 0 ? 'up' : 'down'
        ];
    }

    // Quick date filters
    public function setToday()
    {
        $this->startDate = Carbon::today()->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
    }

    public function setThisWeek()
    {
        $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
    }

    public function setThisMonth()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function setLast30Days()
    {
        $this->startDate = Carbon::now()->subDays(29)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    // Export Feature
    public function exportCsv()
    {
        $data = $this->getRevenueData();
        $fileName = 'revenue_report_' . $this->startDate . '_to_' . $this->endDate . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Total Bookings', 'Average Value', 'Revenue (Rp)']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row['date'],
                    $row['count'],
                    $row['average'],
                    $row['total']
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}