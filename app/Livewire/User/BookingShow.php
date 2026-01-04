<?php

namespace App\Livewire\User;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

#[Layout('layouts.app')]
class BookingShow extends Component
{
    public Booking $booking;
    public User $user;

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Download invoice PDF
     */
    public function downloadInvoice(int $bookingId): StreamedResponse
    {
        $booking = Booking::with(['user', 'package.mountain', 'items.equipment'])
            ->findOrFail($bookingId);

        // Security check (user hanya boleh download invoice miliknya)
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.invoice', [
            'booking' => $booking
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'invoice-' . $booking->booking_code . '.pdf'
        );
    }

    /**
     * Optional: cancel modal
     */
    public function openCancelModal(int $bookingId)
    {
        // logic modal cancel (kalau ada)
    }

    public function render()
    {
        return view('livewire.user.booking-show');
    }
}
