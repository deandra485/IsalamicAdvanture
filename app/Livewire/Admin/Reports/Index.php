<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    public $startDate;
    public $endDate;
    public $period = 'daily'; // daily | monthly

    public function mount()
    {
        // Default 30 hari terakhir
        $this->startDate = Carbon::now()->subDays(29)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.reports.index', [
            'totalRevenue'  => $this->getTotalRevenue(),
            'totalBookings' => $this->getTotalBookings(),
            'newCustomers'  => $this->getNewCustomersCount(),
            'revenueChart'  => $this->getRevenueData(), // Data untuk Grafik
            'topMountains'  => $this->getTopMountains(),
            'topEquipment'  => $this->getTopEquipment(),
        ]);
    }

    // --- Data Getters ---

    private function getBaseQuery()
    {
        return Booking::where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate]);
    }

    public function getTotalRevenue()
    {
        return $this->getBaseQuery()->sum('total_biaya');
    }

    public function getTotalBookings()
    {
        return $this->getBaseQuery()->count();
    }

    public function getNewCustomersCount()
    {
        return User::where('role', 'customer')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(), 
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->count();
    }

    public function getRevenueData()
    {
        // Tentukan format grouping MySQL berdasarkan pilihan user
        $format = $this->period === 'monthly' ? '%Y-%m' : '%Y-%m-%d';
        
        // Query database
        $data = Booking::where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->select(
                DB::raw("DATE_FORMAT(tanggal_mulai, '$format') as date"), 
                DB::raw('sum(total_biaya) as total'), 
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // MAPPING PENTING:
        // Ubah hasil query menjadi format yang ramah JavaScript (Chart)
        // Pastikan 'total' di-cast menjadi (int) agar tidak dianggap string oleh JS
        return $data->map(function ($item) {
            return [
                'date'  => $item->date,
                'total' => (int) $item->total,
                'count' => (int) $item->count,
            ];
        });
    }

    public function getTopMountains()
    {
        // Menggunakan Eager Loading untuk performa
        $bookings = Booking::with('package.mountain')
            ->where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->get();

        $stats = [];
        foreach ($bookings as $booking) {
            // Null coalescing operator menjaga jika paket/gunung terhapus
            $namaGunung = $booking->package->mountain->nama_gunung ?? 'Unknown/Deleted';
            
            if (!isset($stats[$namaGunung])) {
                $stats[$namaGunung] = 0;
            }
            $stats[$namaGunung]++;
        }

        arsort($stats); // Urutkan dari terbesar
        
        return array_slice($stats, 0, 5); // Ambil Top 5
    }

    public function getTopEquipment()
    {
        // Mengambil data equipment dari relasi many-to-many via package
        $bookings = Booking::with(['package.equipment'])
            ->where('status_booking', 'confirmed')
            ->whereBetween('tanggal_mulai', [$this->startDate, $this->endDate])
            ->get();

        $equipmentStats = [];

        foreach ($bookings as $booking) {
            if ($booking->package && $booking->package->equipment) {
                foreach ($booking->package->equipment as $eq) {
                    // Ambil quantity dari pivot table (package_equipment)
                    $qtyInPackage = $eq->pivot->quantity ?? 1;
                    
                    if (!isset($equipmentStats[$eq->id])) {
                        $equipmentStats[$eq->id] = [
                            'name' => $eq->nama_barang,
                            'total_usage' => 0
                        ];
                    }
                    $equipmentStats[$eq->id]['total_usage'] += $qtyInPackage;
                }
            }
        }

        // Return collection agar mudah di-loop di blade
        return collect($equipmentStats)->sortByDesc('total_usage')->take(5);
    }

    // --- Export Feature (CSV) ---
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
            fputcsv($file, ['Date', 'Total Bookings', 'Revenue (Rp)']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row['date'],   // Akses array karena sudah di-map di getRevenueData
                    $row['count'], 
                    $row['total']
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}