<?php
// ==========================================
// APP/LIVEWIRE/HOME.PHP
// ==========================================

namespace App\Livewire;

use App\Models\Mountain;
use Livewire\Attributes\Layout;
use App\Models\Equipment;
use App\Models\Review;
use Livewire\Component;

#[layout('layouts.app')]
class Home extends Component
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

        return view('livewire.home', [
            'featuredMountains' => $featuredMountains,
            'popularEquipment' => $popularEquipment,
            'latestReviews' => $latestReviews,
        ]);
    }
}