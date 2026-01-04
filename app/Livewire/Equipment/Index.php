<?php
// ==========================================
// APP/LIVEWIRE/EQUIPMENT/INDEX.PHP
// ==========================================

namespace App\Livewire\Equipment;

use App\Models\Equipment;
use Livewire\Attributes\Layout;
use App\Models\Category;
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
    public $category = '';
    
    #[Url]
    public $kondisi = '';
    
    #[Url]
    public $sortBy = 'nama_peralatan';
    
    #[Url]
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingKondisi()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Equipment::with(['category', 'primaryImage'])
            ->where('is_available', true);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_peralatan', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhere('merk', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->kondisi) {
            $query->where('kondisi', $this->kondisi);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $equipment = $query->paginate(12);
        $categories = Category::withCount('equipment')->get();

        return view('livewire.equipment.index', [
            'equipment' => $equipment,
            'categories' => $categories,
        ]);
    }
}