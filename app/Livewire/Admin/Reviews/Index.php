<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all'; // all, approved, pending
    public $filterRating = 'all'; // all, 1, 2, 3, 4, 5
    public $selectedReview = null;
    public $showDetailModal = false;
    public $showDeleteModal = false;
    public $deleteReviewId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
        'filterRating' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterRating()
    {
        $this->resetPage();
    }

    public function getReviewsProperty()
    {
        $query = Review::with(['user', 'mountain', 'booking', 'approvedBy'])
            ->latest();

        // Filter by search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('komentar', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('mountain', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter by status
        if ($this->filterStatus === 'approved') {
            $query->approved();
        } elseif ($this->filterStatus === 'pending') {
            $query->pending();
        }

        // Filter by rating
        if ($this->filterRating !== 'all') {
            $query->where('rating', $this->filterRating);
        }

        return $query->paginate(10);
    }

    public function viewDetail($reviewId)
    {
        $this->selectedReview = Review::with(['user', 'mountain', 'booking', 'approvedBy'])
            ->find($reviewId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedReview = null;
    }

    public function approveReview($reviewId)
    {
        $review = Review::find($reviewId);
        
        if ($review) {
            $review->update([
                'is_approved' => true,
                'approved_by' => auth()->id(),
            ]);

            session()->flash('success', 'Review berhasil disetujui.');
            
            if ($this->selectedReview && $this->selectedReview->id === $reviewId) {
                $this->selectedReview = Review::with(['user', 'mountain', 'booking', 'approvedBy'])
                    ->find($reviewId);
            }
        }
    }

    public function rejectReview($reviewId)
    {
        $review = Review::find($reviewId);
        
        if ($review) {
            $review->update([
                'is_approved' => false,
                'approved_by' => null,
            ]);

            session()->flash('success', 'Review berhasil ditolak.');
            
            if ($this->selectedReview && $this->selectedReview->id === $reviewId) {
                $this->selectedReview = Review::with(['user', 'mountain', 'booking', 'approvedBy'])
                    ->find($reviewId);
            }
        }
    }

    public function confirmDelete($reviewId)
    {
        $this->deleteReviewId = $reviewId;
        $this->showDeleteModal = true;
    }

    public function deleteReview()
    {
        if ($this->deleteReviewId) {
            $review = Review::find($this->deleteReviewId);
            
            if ($review) {
                // Delete photos if exist
                if (!empty($review->photos)) {
                    foreach ($review->photos as $photo) {
                        \Storage::disk('public')->delete($photo);
                    }
                }
                
                $review->delete();
                session()->flash('success', 'Review berhasil dihapus.');
            }
        }

        $this->showDeleteModal = false;
        $this->deleteReviewId = null;
        
        if ($this->showDetailModal) {
            $this->closeDetailModal();
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteReviewId = null;
    }

    public function getStatsProperty()
    {
        return [
            'total' => Review::count(),
            'approved' => Review::approved()->count(),
            'pending' => Review::pending()->count(),
            'avg_rating' => round(Review::approved()->avg('rating'), 1),
        ];
    }

    public function render()
    {
        return view('livewire.admin.reviews.index', [
            'reviews' => $this->reviews,
            'stats' => $this->stats,
        ]);
    }
}