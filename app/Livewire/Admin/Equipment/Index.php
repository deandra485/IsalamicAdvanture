<?php
// ==========================================
// APP/LIVEWIRE/ADMIN/EQUIPMENT/INDEX.PHP
// ==========================================

namespace App\Livewire\Admin\Equipment;

use App\Models\Equipment;
use Livewire\Attributes\Layout;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

#[layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $kondisiFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // Bulk actions
    public $selectedItems = [];
    public $selectAll = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = Equipment::pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function toggleStatus($equipmentId)
    {
        $equipment = Equipment::findOrFail($equipmentId);
        $equipment->update(['is_available' => !$equipment->is_available]);

        \App\Models\ActivityLog::log(
            'update',
            'equipment',
            $equipmentId,
            'Toggled equipment availability to ' . ($equipment->is_available ? 'available' : 'unavailable')
        );

        session()->flash('success', 'Status peralatan berhasil diubah!');
    }

    public function deleteEquipment($equipmentId)
    {
        try {
            $equipment = Equipment::findOrFail($equipmentId);
            
            // Delete images
            foreach ($equipment->images as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }

            $equipmentName = $equipment->nama_peralatan;
            $equipment->delete();

            \App\Models\ActivityLog::log(
                'delete',
                'equipment',
                $equipmentId,
                'Deleted equipment: ' . $equipmentName
            );

            session()->flash('success', 'Peralatan berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih item terlebih dahulu!');
            return;
        }

        try {
            $equipment = Equipment::whereIn('id', $this->selectedItems)->get();
            
            foreach ($equipment as $item) {
                // Delete images
                foreach ($item->images as $image) {
                    Storage::disk('public')->delete($image->image_url);
                    $image->delete();
                }
                $item->delete();
            }

            session()->flash('success', count($this->selectedItems) . ' peralatan berhasil dihapus!');
            $this->selectedItems = [];
            $this->selectAll = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function bulkActivate()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih item terlebih dahulu!');
            return;
        }

        Equipment::whereIn('id', $this->selectedItems)->update(['is_available' => true]);
        session()->flash('success', count($this->selectedItems) . ' peralatan berhasil diaktifkan!');
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function bulkDeactivate()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih item terlebih dahulu!');
            return;
        }

        Equipment::whereIn('id', $this->selectedItems)->update(['is_available' => false]);
        session()->flash('success', count($this->selectedItems) . ' peralatan berhasil dinonaktifkan!');
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function render()
    {
        $query = Equipment::with(['category', 'primaryImage']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_peralatan', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhere('merk', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->statusFilter !== '') {
            $query->where('is_available', $this->statusFilter);
        }

        if ($this->kondisiFilter) {
            $query->where('kondisi', $this->kondisiFilter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $equipment = $query->paginate(10);
        $categories = Category::orderBy('nama_kategori')->get();

        return view('livewire.admin.equipment.index', [
            'equipment' => $equipment,
            'categories' => $categories,
        ]);
    }
}