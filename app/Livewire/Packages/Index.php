<?php

namespace App\Livewire\Packages;

use App\Models\Package;
use App\Models\Mountain;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $mountainFilter = '';
    public $sortBy = 'nama_paket';
    public $sortDirection = 'asc';
    public $perPage = 9;
    public ?User $user = null;


    protected $queryString = [
        'search' => ['except' => ''],
        'mountainFilter' => ['except' => ''],
        'sortBy' => ['except' => 'nama_paket'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        $this->user = Auth::user();
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMountainFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'mountainFilter',
            'sortBy',
            'sortDirection',
        ]);

        $this->resetPage();
    }

    public function addToCart($packageId)
    {
        if (!$this->user) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk menambahkan paket ke keranjang.');
            return redirect()->route('login');
        }

        $cartItem = $this->user
            ->cartItems()
            ->where('package_id', $packageId)
            ->first();

        if ($cartItem) {
            session()->flash('info', 'Paket sudah ada di keranjang Anda.');
        } else {
            $this->user->cartItems()->create([
                'package_id' => $packageId,
                'quantity' => 1,
            ]);

            session()->flash('success', 'Paket berhasil ditambahkan ke keranjang!');
        }

        $this->dispatch('cart-updated');
    }

    public function render()
    {
        $query = Package::with(['mountain', 'equipment'])
            ->where('is_active', true);

        /**
         * 🔍 SEARCH
         */
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_paket', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('mountain', function ($m) {
                      $m->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        /**
         * 🏔️ FILTER GUNUNG
         */
        if ($this->mountainFilter) {
            $query->where('mountain_id', $this->mountainFilter);
        }

        /**
         * ↕️ SORTING (AMAN & SESUAI DB)
         */
        $allowedSorts = [
            'nama_paket',
            'harga_paket',
            'durasi_hari',
        ];

        if (!in_array($this->sortBy, $allowedSorts)) {
            $this->sortBy = 'nama_paket';
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $packages = $query->paginate($this->perPage);

        $mountains = Mountain::where('is_active', true)
            ->orderBy('nama_gunung')
            ->get();

        return view('livewire.packages.index', compact('packages', 'mountains'));
    }
}
