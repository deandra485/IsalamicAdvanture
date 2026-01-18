<?php

namespace App\Livewire\User;

use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
#[Layout('layouts.app')]
class BookingHistory extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $searchTerm = '';
    public $showDetailModal = false;
    public $selectedBooking = null;
    public $showCancelModal = false;
    public $cancelReason = '';

    protected $queryString = [
        'statusFilter' => ['except' => ''],
        'searchTerm' => ['except' => ''],
    ];

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
{
    $bookings = Booking::with([
            'package.mountain',
            'items.equipment',
            'payment'
        ])
        ->where('user_id', Auth::id())
        ->when($this->statusFilter, fn ($q) =>
            $q->where('status_booking', $this->statusFilter)
        )
        ->when($this->searchTerm, function ($q) {
            $q->where(function ($sub) {
                $sub->where('kode_booking', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('package', fn ($p) =>
                        $p->where('nama_paket', 'like', '%' . $this->searchTerm . '%')
                    )
                    ->orWhereHas('items.equipment', fn ($e) =>
                        $e->where('nama_peralatan', 'like', '%' . $this->searchTerm . '%')
                    );
            });
        })
        ->latest()
        ->paginate(10);

    return view('livewire.user.booking-history', [
        'bookings' => $bookings,
        'statuses' => [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ]
    ]);
}


    public function viewDetail($bookingId)
    {
        $this->selectedBooking = Booking::with([
            'package.mountain',
            'package.equipment',
            'Items.equipment.primaryImage',
            'payment'
        ])->findOrFail($bookingId);
        
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedBooking = null;
    }

    public function openCancelModal($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        if (!in_array($booking->status_booking, ['pending', 'confirmed'])) {
            session()->flash('error', 'Booking tidak dapat dibatalkan.');
            return;
        }

        $this->selectedBooking = $booking;
        $this->showCancelModal = true;
    }

    public function cancelBooking()
    {
        $this->validate([
            'cancelReason' => 'required|min:10|max:500'
        ], [
            'cancelReason.required' => 'Alasan pembatalan harus diisi.',
            'cancelReason.min' => 'Alasan pembatalan minimal 10 karakter.',
            'cancelReason.max' => 'Alasan pembatalan maksimal 500 karakter.'
        ]);

        if ($this->selectedBooking) {
            // Update booking status
            $this->selectedBooking->update([
                'status_booking' => 'cancelled',
                'catatan' => 'Dibatalkan oleh user: ' . $this->cancelReason
            ]);

            // Update payment status if exists
            if ($this->selectedBooking->payment) {
                $this->selectedBooking->payment->update([
                    'status_pembayaran' => 'cancelled'
                ]);
            }

            // Return stock for equipment bookings
            foreach ($this->selectedBooking->bookingItems as $item) {
                $equipment = $item->equipment;
                $equipment->increment('stok_tersedia', $item->quantity);
            }

            session()->flash('success', 'Booking berhasil dibatalkan.');
            
            $this->showCancelModal = false;
            $this->selectedBooking = null;
            $this->cancelReason = '';
        }
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->selectedBooking = null;
        $this->cancelReason = '';
    }

    public function downloadInvoice($bookingId)
    {
        $booking = Booking::with([
            'user',
            'package.mountain',
            'Items.equipment',
            'payment'
        ])->findOrFail($bookingId);

        // Check if booking belongs to current user
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.invoice', [
            'booking' => $booking
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice-' . $booking->kode_booking . '.pdf');
    }

    public function getStatusBadgeClass($status)
    {
        return match ($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'ongoing' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}