<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    /* ================= STATE ================= */

    public string $status = 'pending';
    public string $search = '';
    public string $dateFrom = '';
    public string $dateTo = '';
    public string $sortBy = 'tanggal_pembayaran';
    public string $sortDirection = 'desc';

    protected $queryString = [
        'status' => ['except' => 'pending'],
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'tanggal_pembayaran'],
        'sortDirection' => ['except' => 'desc'],
    ];

    /* ================= LIFECYCLE ================= */

    public function mount(): void
    {
        $this->dateFrom = now()->subDays(30)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    /* ================= COMPUTED PROPERTIES ================= */

    #[Computed]
    public function payments()
    {
        return Payment::with(['booking.user', 'booking.package'])
            ->when($this->status !== 'all', fn($q) => 
                $q->where('status_pembayaran', $this->status)
            )
            ->when($this->search, function($q) {
                $q->whereHas('booking.user', function($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
                })
                ->orWhereHas('booking', function($q) {
                    $q->where('kode_booking', 'like', "%{$this->search}%");
                });
            })
            ->when($this->dateFrom, fn($q) => 
                $q->whereDate('tanggal_pembayaran', '>=', $this->dateFrom)
            )
            ->when($this->dateTo, fn($q) => 
                $q->whereDate('tanggal_pembayaran', '<=', $this->dateTo)
            )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);
    }

    #[Computed]
    public function stats()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        return [
            'pending' => Payment::where('status_pembayaran', 'pending')->count(),
            
            'verified' => Payment::where('status_pembayaran', 'verified')
                ->whereMonth('tanggal_pembayaran', $currentMonth)
                ->whereYear('tanggal_pembayaran', $currentYear)
                ->count(),
            
            'rejected' => Payment::where('status_pembayaran', 'rejected')
                ->whereMonth('tanggal_pembayaran', $currentMonth)
                ->whereYear('tanggal_pembayaran', $currentYear)
                ->count(),
            
            'total_amount' => Payment::where('status_pembayaran', 'verified')
                ->whereMonth('tanggal_pembayaran', $currentMonth)
                ->whereYear('tanggal_pembayaran', $currentYear)
                ->sum('jumlah_bayar'),

            'today_verified' => Payment::where('status_pembayaran', 'verified')
                ->whereDate('tanggal_pembayaran', today())
                ->count(),
        ];
    }

    /* ================= REACTIVE UPDATES ================= */

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    /* ================= SORTING ================= */

    public function sortBy(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    /* ================= FILTERS ================= */

    public function setStatus(string $status): void
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['status', 'search', 'dateFrom', 'dateTo', 'sortBy', 'sortDirection']);
        $this->dateFrom = now()->subDays(30)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
        $this->resetPage();
    }

    public function setDateRange(string $range): void
    {
        match($range) {
            'today' => [
                $this->dateFrom = today()->format('Y-m-d'),
                $this->dateTo = today()->format('Y-m-d')
            ],
            'week' => [
                $this->dateFrom = now()->subWeek()->format('Y-m-d'),
                $this->dateTo = now()->format('Y-m-d')
            ],
            'month' => [
                $this->dateFrom = now()->subMonth()->format('Y-m-d'),
                $this->dateTo = now()->format('Y-m-d')
            ],
            'year' => [
                $this->dateFrom = now()->subYear()->format('Y-m-d'),
                $this->dateTo = now()->format('Y-m-d')
            ],
            default => null
        };

        $this->resetPage();
    }

    /* ================= RENDER ================= */

    public function render()
    {
        return view('livewire.admin.payments.index');
    }
}