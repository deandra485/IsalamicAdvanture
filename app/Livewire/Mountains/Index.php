<?php
// ==========================================
// APP/LIVEWIRE/MOUNTAINS/INDEX.PHP
// ==========================================

namespace App\Livewire\Mountains;

use App\Models\Mountain;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

#[layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $lokasi = '';
    
    #[Url]
    public $tingkat_kesulitan = '';
    
    #[Url]
    public $sortBy = 'nama_gunung';
    
    #[Url]
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLokasi()
    {
        $this->resetPage();
    }

    public function updatingTingkatKesulitan()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Mountain::where('is_active', true);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_gunung', 'like', '%' . $this->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->lokasi) {
            $query->where('lokasi', 'like', '%' . $this->lokasi . '%');
        }

        if ($this->tingkat_kesulitan) {
            $query->where('tingkat_kesulitan', $this->tingkat_kesulitan);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $mountains = $query->paginate(12);
        
        $locations = Mountain::where('is_active', true)
            ->distinct()
            ->pluck('lokasi')
            ->sort()
            ->values();

        return view('livewire.mountains.index', [
            'mountains' => $mountains,
            'locations' => $locations,
        ]);
    }
}