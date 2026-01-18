<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; // all, approved, pending

    // Reset pagination saat search berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Toggle status Approved/Pending
    public function toggleStatus($id)
    {
        $review = Review::find($id);
        
        if ($review) {
            $newStatus = !$review->is_approved;
            
            $review->update([
                'is_approved' => $newStatus,
                'approved_by' => $newStatus ? Auth::id() : null
            ]);

            $statusText = $newStatus ? 'approved' : 'rejected (pending)';
            session()->flash('success', "Review successfully {$statusText}.");
        }
    }

    public function delete($id)
    {
        $review = Review::find($id);

        if ($review) {
            $review->delete();
            session()->flash('success', 'Review deleted successfully.');
        }
    }

    public function render()
    {
        $reviews = Review::with(['user', 'mountain'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('komentar', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function($u) {
                          $u->where('name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('mountain', function($m) {
                          $m->where('nama_gunung', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter !== 'all', function($query) {
                if ($this->statusFilter === 'approved') {
                    $query->where('is_approved', true);
                } else {
                    $query->where('is_approved', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.reviews.index', [
            'reviews' => $reviews
        ]);
    }
}