<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Mountain;
use App\Models\Equipment;
use App\Models\Review;
use Livewire\Attributes\Layout;

#[layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $featuredMountains = Mountain::where('is_active', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->limit(6)
            ->get();

        $popularEquipment = Equipment::where('is_available', true)
            ->withCount('bookingItems')
            ->orderBy('booking_items_count', 'desc')
            ->limit(8)
            ->get();

        $latestReviews = Review::where('is_approved', true)
            ->with(['user', 'mountain'])
            ->latest()
            ->limit(6)
            ->get();

        $latestBookingsHistory = BookingHistory::where('is_approved', true)
            ->with(['mountain', 'equipment', 'payment'])
            ->latest()
            ->limit(5)
            ->get();
        return view('livewire.user.dashboard');
    }
}
