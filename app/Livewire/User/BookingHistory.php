<?php

namespace App\Livewire\User;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('layouts.app')]
class BookingHistory extends Component
{
    use WithPagination;

    public ?User $user = null;

    public $statusFilter = '';
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    public $showCancelModal = false;
    public ?Booking $bookingToCancel = null;
    public $cancelReason = '';

    protected $queryString = [
        'statusFilter'   => ['except' => ''],
        'search'         => ['except' => ''],
        'sortBy'         => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount(): void
    {
        $this->user = Auth::user();

        if (!$this->user) {
            abort(403);
        }
    }

    /* =====================
        FILTER & SORT
    ====================== */

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function sortByField(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearFilters(): void
    {
        $this->reset([
            'search',
            'statusFilter',
            'sortBy',
            'sortDirection',
        ]);

        $this->resetPage();
    }

    /* =====================
        CANCEL BOOKING
    ====================== */

    public function openCancelModal(int $bookingId): void
    {
        $booking = Booking::with('items.equipment')->findOrFail($bookingId);

        if ($booking->user_id !== $this->user->id) {
            session()->flash('error', 'Akses tidak valid.');
            return;
        }

        if (!$booking->canBeCancelled()) {
            session()->flash('error', 'Booking ini tidak dapat dibatalkan.');
            return;
        }

        $this->bookingToCancel = $booking;
        $this->cancelReason = '';
        $this->showCancelModal = true;
    }

    public function closeCancelModal(): void
    {
        $this->reset([
            'showCancelModal',
            'bookingToCancel',
            'cancelReason',
        ]);
    }

    public function cancelBooking(): void
    {
        $this->validate([
            'cancelReason' => 'required|min:10|max:500',
        ]);

        if (
            !$this->bookingToCancel ||
            $this->bookingToCancel->user_id !== $this->user->id
        ) {
            session()->flash('error', 'Booking tidak valid.');
            return;
        }

        if (!$this->bookingToCancel->canBeCancelled()) {
            session()->flash('error', 'Booking ini tidak dapat dibatalkan.');
            return;
        }

        // Update status booking
        $this->bookingToCancel->update([
            'status_booking'   => 'cancelled',
            'catatan_customer' => $this->cancelReason,
        ]);

        // Kembalikan stok equipment
        foreach ($this->bookingToCancel->items as $item) {
            if ($item->equipment) {
                $item->equipment->increment('stock', $item->quantity);
            }
        }

        session()->flash('success', 'Booking berhasil dibatalkan.');
        $this->closeCancelModal();
    }

    /* =====================
        INVOICE PDF
    ====================== */

    public function downloadInvoice(int $bookingId)
    {
        $booking = Booking::with([
            'user',
            'package.mountain',
            'items.equipment',
            'payment',
        ])->findOrFail($bookingId);

        if ($booking->user_id !== $this->user->id) {
            session()->flash('error', 'Anda tidak memiliki akses ke invoice ini.');
            return;
        }

        $pdf = Pdf::loadView('pdf.invoice', [
            'booking' => $booking,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'invoice-' . $booking->id . '.pdf'
        );
    }

    /* =====================
        RENDER
    ====================== */

    public function render()
    {
        $query = Booking::with([
            'package.mountain',
            'items',
        ])->where('user_id', $this->user->id);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('package', fn ($q) =>
                      $q->where('name', 'like', '%' . $this->search . '%')
                  )
                  ->orWhereHas('package.mountain', fn ($q) =>
                      $q->where('name', 'like', '%' . $this->search . '%')
                  );
            });
        }

        if ($this->statusFilter) {
            $query->where('status_booking', $this->statusFilter);
        }

        $bookings = $query
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $statusCounts = Booking::where('user_id', $this->user->id)
            ->selectRaw('status_booking, COUNT(*) as total')
            ->groupBy('status_booking')
            ->pluck('total', 'status_booking');

        return view('livewire.user.booking-history', [
            'bookings'     => $bookings,
            'statusCounts' => $statusCounts,
        ]);
    }
}
