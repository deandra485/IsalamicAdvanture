<?php
// ==========================================
// APP/LIVEWIRE/ADMIN/BOOKINGS/INDEX.PHP
// ==========================================

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateStatus($bookingId, $newStatus)
    {
        try {
            $booking = Booking::findOrFail($bookingId);
            $oldStatus = $booking->status_booking;
            
            $booking->update([
                'status_booking' => $newStatus,
                'confirmed_by' => Auth::id(),
            ]);

            // Log activity
            \App\Models\ActivityLog::log(
                'update',
                'bookings',
                $bookingId,
                "Changed booking status from {$oldStatus} to {$newStatus}"
            );

            // Send notification to customer
            if ($newStatus === 'confirmed') {
                $booking->user->notify(new \App\Notifications\BookingConfirmed($booking));
            }

            session()->flash('success', 'Status booking berhasil diubah!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Booking::with(['user', 'items.equipment', 'payment']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q2) {
                      $q2->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status_booking', $this->statusFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $bookings = $query->paginate(15);

        // Stats
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status_booking', 'pending')->count(),
            'confirmed' => Booking::where('status_booking', 'confirmed')->count(),
            'ongoing' => Booking::where('status_booking', 'ongoing')->count(),
            'completed' => Booking::where('status_booking', 'completed')->count(),
            'cancelled' => Booking::where('status_booking', 'cancelled')->count(),
        ];

        return view('livewire.admin.bookings.index', [
            'bookings' => $bookings,
            'stats' => $stats,
        ]);
    }
}