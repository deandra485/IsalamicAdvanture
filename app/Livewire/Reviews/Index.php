<?php

namespace App\Livewire\Reviews;

use App\Models\Booking;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        // Ambil booking yang completed dan belum direview
        $bookings = Booking::with(['mountain'])
            ->where('user_id', auth()->id())
            ->where('status_booking', 'completed')
            ->whereDoesntHave('review', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('livewire.reviews.index', [
            'bookings' => $bookings,
        ]);
    }
}