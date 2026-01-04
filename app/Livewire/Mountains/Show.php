<?php

namespace App\Livewire\Mountains;

use App\Models\Mountain;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[layout('layouts.app')]
class Show extends Component
{
    public Mountain $mountain;

    public function mount(Mountain $mountain)
    {
        $this->mountain = $mountain->load([
            'hikingRoutes',
            'packages.equipment',
            'reviews' => function($query) {
                $query->where('is_approved', true)->latest()->take(6);
            },
            'reviews.user'
        ]);
    }

    public function render()
    {
        return view('livewire.mountains.show');
    }
}
