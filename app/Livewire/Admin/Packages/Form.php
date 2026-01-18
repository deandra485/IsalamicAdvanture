<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Package;
use App\Models\Mountain;
use App\Models\Equipment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Package $package = null; // Jika null = Create mode
    
    // Form Properties
    public $mountain_id;
    public $nama_paket;
    public $deskripsi;
    public $harga_paket;
    public $durasi_hari = 1;
    public $max_peserta = 1;
    public $include_guide = false;
    public $is_active = true;

    // Equipment Management
    public $packageItems = []; // Array [equipment_id, quantity]
    
    // Dropdown Data
    public $mountains;
    public $allEquipment;

    public function mount($id = null)
    {
        $this->mountains = Mountain::all();
        $this->allEquipment = Equipment::orderBy('nama_peralatan')->get();

        if ($id) {
            $this->package = Package::with('equipment')->findOrFail($id);
            
            // Fill basic info
            $this->mountain_id = $this->package->mountain_id;
            $this->nama_paket = $this->package->nama_paket;
            $this->deskripsi = $this->package->deskripsi;
            $this->harga_paket = $this->package->harga_paket;
            $this->durasi_hari = $this->package->durasi_hari;
            $this->max_peserta = $this->package->max_peserta;
            $this->include_guide = $this->package->include_guide;
            $this->is_active = $this->package->is_active;

            // Load existing equipment pivot
            foreach ($this->package->equipment as $item) {
                $this->packageItems[] = [
                    'equipment_id' => $item->id,
                    'quantity' => $item->pivot->quantity
                ];
            }
        } else {
            // Default item row for create mode
            $this->addItemRow();
        }
    }

    public function addItemRow()
    {
        $this->packageItems[] = ['equipment_id' => '', 'quantity' => 1];
    }

    public function removeItemRow($index)
    {
        unset($this->packageItems[$index]);
        $this->packageItems = array_values($this->packageItems); // Re-index array
    }

    protected function rules()
    {
        return [
            'mountain_id' => 'required|exists:mountains,id',
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_paket' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
            'max_peserta' => 'required|integer|min:1',
            'include_guide' => 'boolean',
            'is_active' => 'boolean',
            'packageItems.*.equipment_id' => 'nullable|exists:equipment,id',
            'packageItems.*.quantity' => 'required_with:packageItems.*.equipment_id|integer|min:1',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'mountain_id' => $this->mountain_id,
            'nama_paket' => $this->nama_paket,
            'deskripsi' => $this->deskripsi,
            'harga_paket' => $this->harga_paket,
            'durasi_hari' => $this->durasi_hari,
            'max_peserta' => $this->max_peserta,
            'include_guide' => $this->include_guide,
            'is_active' => $this->is_active,
        ];

        if ($this->package) {
            // Update
            $this->package->update($data);
        } else {
            // Create
            $data['created_by'] = Auth::id();
            $this->package = Package::create($data);
        }

        // Sync Equipment (Many-to-Many Pivot)
        $syncData = [];
        foreach ($this->packageItems as $item) {
            if (!empty($item['equipment_id']) && $item['quantity'] > 0) {
                // Format: [id => ['quantity' => val]]
                $syncData[$item['equipment_id']] = ['quantity' => $item['quantity']];
            }
        }
        
        $this->package->equipment()->sync($syncData);

        session()->flash('success', 'Package saved successfully.');
        return redirect()->route('admin.packages.index');
    }

    public function render()
    {
        return view('livewire.admin.packages.form');
    }
}