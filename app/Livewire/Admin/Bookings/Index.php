<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // ✅ PERBAIKAN: Tracking status changes per booking
    public $statusChanges = [];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingDateFilter() { $this->resetPage(); }
    public function updatingSortBy() { $this->resetPage(); }

    // ✅ PERBAIKAN: Simplified updateStatus method
    public function updateStatus($bookingId)
    {
        $newStatus = $this->statusChanges[$bookingId] ?? null;
        
        if (!$newStatus) {
            session()->flash('error', 'Status tidak valid!');
            return;
        }

        $validStatuses = ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled'];
        
        if (!in_array($newStatus, $validStatuses)) {
            session()->flash('error', 'Status tidak valid!'); 
            return;
        }

        try {
            $booking = Booking::findOrFail($bookingId);
            $oldStatus = $booking->status_booking;

            if ($oldStatus === $newStatus) {
                return;
            }
            
            // Update Database
            $booking->update([
                'status_booking' => $newStatus,
                'confirmed_by'   => Auth::id(), 
            ]);

            // Kirim Notifikasi
            if ($newStatus === 'confirmed' && class_exists('\App\Notifications\BookingConfirmed')) {
                try {
                    $booking->user->notify(new \App\Notifications\BookingConfirmed($booking));
                } catch (\Throwable $e) {
                    Log::error('Gagal kirim email: ' . $e->getMessage());
                }
            }

            session()->flash('success', "Booking #{$bookingId} berubah dari {$oldStatus} menjadi {$newStatus}");
            
        } catch (\Throwable $e) {
            Log::error('Update Status Error: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Booking::with(['user', 'payment', 'items']); 

        // Filter Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($u) {
                      $u->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filter Status
        if ($this->statusFilter) {
            $query->where('status_booking', $this->statusFilter);
        }

        // Filter Date
        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        // Sorting
        $allowedSorts = ['created_at', 'tanggal_mulai', 'total_biaya'];
        $sortColumn = in_array($this->sortBy, $allowedSorts) ? $this->sortBy : 'created_at';
        
        $query->orderBy($sortColumn, $this->sortDirection);

        $bookings = $query->paginate(10);

        // ✅ PERBAIKAN: Initialize statusChanges untuk setiap booking
        foreach ($bookings as $booking) {
            if (!isset($this->statusChanges[$booking->id])) {
                $this->statusChanges[$booking->id] = $booking->status_booking;
            }
        }

        // Stats
        $statsRaw = Booking::selectRaw('status_booking, count(*) as total')
                    ->groupBy('status_booking')
                    ->pluck('total', 'status_booking')
                    ->toArray();

        $stats = [
            'total'     => array_sum($statsRaw),
            'pending'   => $statsRaw['pending'] ?? 0,
            'confirmed' => $statsRaw['confirmed'] ?? 0,
            'ongoing'   => $statsRaw['ongoing'] ?? 0,
            'completed' => $statsRaw['completed'] ?? 0,
            'cancelled' => $statsRaw['cancelled'] ?? 0,
        ];

        return view('livewire.admin.bookings.index', [
            'bookings' => $bookings,
            'stats' => $stats,
        ]);
    }
}