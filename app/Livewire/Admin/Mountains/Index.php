<?php
// ==========================================
// APP/LIVEWIRE/ADMIN/MOUNTAINS/INDEX.PHP
// ==========================================

namespace App\Livewire\Admin\Mountains;

use App\Models\Mountain;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;


#[layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $tingkatKesulitanFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($mountainId)
    {
        $mountain = Mountain::findOrFail($mountainId);
        $mountain->update(['is_active' => !$mountain->is_active]);

        // Log activity
        \App\Models\ActivityLog::log(
            'update',
            'mountains',
            $mountainId,
            'Toggled mountain status to ' . ($mountain->is_active ? 'active' : 'inactive')
        );

        session()->flash('success', 'Status gunung berhasil diubah!');
    }

    public function deleteMountain($mountainId)
    {
        try {
            $mountain = Mountain::findOrFail($mountainId);
            
            // Delete image if exists
            if ($mountain->image_url) {
                Storage::disk('public')->delete($mountain->image_url);
            }

            $mountainName = $mountain->nama_gunung;
            $mountain->delete();

            // Log activity
            \App\Models\ActivityLog::log(
                'delete',
                'mountains',
                $mountainId,
                'Deleted mountain: ' . $mountainName
            );

            session()->flash('success', 'Gunung berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus gunung: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Mountain::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_gunung', 'like', '%' . $this->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter);
        }

        if ($this->tingkatKesulitanFilter) {
            $query->where('tingkat_kesulitan', $this->tingkatKesulitanFilter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $mountains = $query->withCount(['hikingRoutes', 'packages', 'reviews'])
            ->paginate(10);

        return view('livewire.admin.mountains.index', [
            'mountains' => $mountains,
        ]);
    }
}