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

    // Fasilitas & Exclude
    public $fasilitasList = [];
    public $excludeList = [];

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
            $this->mountain_id   = $this->package->mountain_id;
            $this->nama_paket    = $this->package->nama_paket;
            $this->deskripsi     = $this->package->deskripsi;
            $this->harga_paket   = $this->package->harga_paket;
            $this->durasi_hari   = $this->package->durasi_hari;
            $this->max_peserta   = $this->package->max_peserta;
            $this->include_guide = $this->package->include_guide;
            $this->is_active     = $this->package->is_active;

            // Load fasilitas & exclude
            $this->fasilitasList = $this->package->fasilitas ?? [];
            $this->excludeList   = $this->package->exclude ?? [];

            // Load existing equipment pivot
            foreach ($this->package->equipment as $item) {
                $this->packageItems[] = [
                    'equipment_id' => $item->id,
                    'quantity'     => $item->pivot->quantity
                ];
            }
        } else {
            // Default item row for create mode
            $this->addItemRow();

            // Pre-fill fasilitas & exclude dengan data standar
            $this->fasilitasList = [
                'Ojek Pickup (PP)',
                'E-Ticket (Simaksi Pendakian)',
                'Guide / Tour Leader',
                'Sweeper kelompok',
                'Porter Tenda Kelompok',
                'Porter Logistik Kelompok',
                'Tenda Hak Pakai (sesuai kapasitas)',
                'Tenda Toilet (Kuota 15+)',
                'Peralatan Masak Kelompok',
                'Makan 2x (selama pendakian)',
                'Coffee Break di area camp',
                'Buah buahan',
                'Chef Gunung',
                'P3K Standar',
                'Kursi + Meja (kuota 30+)',
                'Peralatan Makan dan Minum',
                'Break Time (sholat 5 waktu)',
                'Dokumentasi Bersama',
                'Kawan nd Family Baru',
            ];

            $this->excludeList = [
                'Perlengkapan Pribadi',
                'Cemilan dan Air Mineral pribadi',
                'Surat Sehat',
                'Yang tidak ada di Include',
            ];
        }
    }

    public function addItemRow()
    {
        $this->packageItems[] = ['equipment_id' => '', 'quantity' => 1];
    }

    public function removeItemRow($index)
    {
        unset($this->packageItems[$index]);
        $this->packageItems = array_values($this->packageItems);
    }

    // ── Fasilitas Methods ──
    public function addFasilitas()
    {
        $this->fasilitasList[] = '';
    }

    public function removeFasilitas($index)
    {
        unset($this->fasilitasList[$index]);
        $this->fasilitasList = array_values($this->fasilitasList);
    }

    // ── Exclude Methods ──
    public function addExclude()
    {
        $this->excludeList[] = '';
    }

    public function removeExclude($index)
    {
        unset($this->excludeList[$index]);
        $this->excludeList = array_values($this->excludeList);
    }

    protected function rules()
    {
        return [
            'mountain_id'                       => 'required|exists:mountains,id',
            'nama_paket'                        => 'required|string|max:255',
            'deskripsi'                         => 'nullable|string',
            'harga_paket'                       => 'required|numeric|min:0',
            'durasi_hari'                       => 'required|integer|min:1',
            'max_peserta'                       => 'required|integer|min:1',
            'include_guide'                     => 'boolean',
            'is_active'                         => 'boolean',
            'fasilitasList'                     => 'nullable|array',
            'fasilitasList.*'                   => 'nullable|string|max:255',
            'excludeList'                       => 'nullable|array',
            'excludeList.*'                     => 'nullable|string|max:255',
            'packageItems.*.equipment_id'       => 'nullable|exists:equipment,id',
            'packageItems.*.quantity'           => 'required_with:packageItems.*.equipment_id|integer|min:1',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'mountain_id'   => $this->mountain_id,
            'nama_paket'    => $this->nama_paket,
            'deskripsi'     => $this->deskripsi,
            'harga_paket'   => $this->harga_paket,
            'durasi_hari'   => $this->durasi_hari,
            'max_peserta'   => $this->max_peserta,
            'include_guide' => $this->include_guide,
            'is_active'     => $this->is_active,
            // Simpan hanya item yang tidak kosong
            'fasilitas'     => array_values(array_filter($this->fasilitasList, fn($v) => !empty(trim($v)))),
            'exclude'       => array_values(array_filter($this->excludeList,   fn($v) => !empty(trim($v)))),
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