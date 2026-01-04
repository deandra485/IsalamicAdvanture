<?php

namespace App\Livewire\Admin\Equipment;

use App\Models\Equipment;
use App\Models\Category;
use Livewire\Attributes\Layout;
use App\Models\EquipmentImage;
use App\Traits\HasFileUpload;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


#[layout('layouts.admin')]
class Form extends Component
{
    use WithFileUploads, HasFileUpload;

    public ?Equipment $equipment = null;
    public $category_id;
    public $nama_peralatan;
    public $deskripsi;
    public $merk;
    public $harga_sewa_perhari;
    public $stok_tersedia;
    public $kondisi = 'baik';
    public $spesifikasi;
    public $is_available = true;
    
    // Images
    public $images = [];
    public $existingImages = [];
    public $primaryImageId;

    protected function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'nama_peralatan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'merk' => 'nullable|string|max:50',
            'harga_sewa_perhari' => 'required|numeric|min:0',
            'stok_tersedia' => 'required|integer|min:0',
            'kondisi' => 'required|in:baru,baik,cukup baik',
            'spesifikasi' => 'nullable|string',
            'is_available' => 'boolean',
            'images.*' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    public function mount(?Equipment $equipment = null)
    {
        if ($equipment && $equipment->exists) {
            $this->equipment = $equipment->load('images');
            $this->fill($equipment->only([
                'category_id', 'nama_peralatan', 'deskripsi', 'merk',
                'harga_sewa_perhari', 'stok_tersedia', 'kondisi',
                'spesifikasi', 'is_available'
            ]));
            
            $this->existingImages = $equipment->images->toArray();
            $primaryImage = $equipment->images->where('is_primary', true)->first();
            $this->primaryImageId = $primaryImage ? $primaryImage->id : null;
        }
    }

    public function removeExistingImage($imageId)
    {
        $image = EquipmentImage::find($imageId);
        if ($image && $image->equipment_id === $this->equipment->id) {
            $this->deleteImage($image->image_url);
            $image->delete();
            
            $this->existingImages = collect($this->existingImages)
                ->reject(fn($img) => $img['id'] == $imageId)
                ->toArray();
                
            session()->flash('success', 'Gambar berhasil dihapus');
        }
    }

    public function setPrimaryImage($imageId)
    {
        $this->primaryImageId = $imageId;
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        
        try {
            $equipmentData = [
                'category_id' => $this->category_id,
                'nama_peralatan' => $this->nama_peralatan,
                'deskripsi' => $this->deskripsi,
                'merk' => $this->merk,
                'harga_sewa_perhari' => $this->harga_sewa_perhari,
                'stok_tersedia' => $this->stok_tersedia,
                'kondisi' => $this->kondisi,
                'spesifikasi' => $this->spesifikasi,
                'is_available' => $this->is_available,
                'created_by' => Auth::id(),
            ];

            if ($this->equipment) {
                $this->equipment->update($equipmentData);
                $action = 'update';
            } else {
                $this->equipment = Equipment::create($equipmentData);
                $action = 'create';
            }

            // Upload new images
            if (!empty($this->images)) {
                foreach ($this->images as $index => $image) {
                    $path = $this->uploadImage($image, 'equipment');
                    
                    EquipmentImage::create([
                        'equipment_id' => $this->equipment->id,
                        'image_url' => $path,
                        'is_primary' => false,
                    ]);
                }
            }

            // Set primary image
            if ($this->primaryImageId) {
                EquipmentImage::where('equipment_id', $this->equipment->id)
                    ->update(['is_primary' => false]);
                    
                EquipmentImage::where('id', $this->primaryImageId)
                    ->update(['is_primary' => true]);
            }

            // Log activity
            \App\Models\ActivityLog::log(
                $action,
                'equipment',
                $this->equipment->id,
                "{$action} equipment: {$this->equipment->nama_peralatan}"
            );

            DB::commit();

            session()->flash('success', 'Peralatan berhasil disimpan!');
            return redirect()->route('admin.equipment.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        
        return view('livewire.admin.equipment.form', [
            'categories' => $categories,
        ]);
    }
}
