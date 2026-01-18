<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $package = Package::find($id);
        
        if ($package) {
            $package->equipment()->detach();
            $package->delete();
            session()->flash('success', 'Package deleted successfully.');
        }
    }

    public function render()
    {
        $packages = Package::with(['mountain', 'equipment'])
            ->where('nama_paket', 'like', '%' . $this->search . '%')
            // PERBAIKAN DI SINI: menggunakan nama_gunung
            ->orWhereHas('mountain', function($q) {
                $q->where('nama_gunung', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.packages.index', [
            'packages' => $packages
        ]);
    }
}