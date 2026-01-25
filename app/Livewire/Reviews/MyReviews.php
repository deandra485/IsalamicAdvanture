<?php

namespace App\Livewire\Reviews;

use App\Models\Review;
use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class MyReviews extends Component
{
    use WithPagination;

    public $selectedBooking = null;
    public $rating = 0;
    public $komentar = '';
    public $showForm = false;

    protected function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:500',
        ];
    }

    protected $messages = [
        'rating.required' => 'Rating wajib diberikan',
        'rating.min' => 'Rating minimal 1 bintang',
        'rating.max' => 'Rating maksimal 5 bintang',
        'komentar.required' => 'Komentar wajib diisi',
        'komentar.min' => 'Komentar minimal 10 karakter',
        'komentar.max' => 'Komentar maksimal 500 karakter',
    ];

    public function selectBooking($bookingId)
    {
        $this->selectedBooking = $bookingId;
        $this->showForm = true;
        $this->rating = 0;
        $this->komentar = '';
        $this->resetValidation();
    }

    public function setRating($value)
    {
        $this->rating = $value;
        $this->resetErrorBag('rating');
    }

    public function cancelForm()
    {
        $this->showForm = false;
        $this->selectedBooking = null;
        $this->rating = 0;
        $this->komentar = '';
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        try {
            $booking = Booking::with('package.mountain')
                ->where('id', $this->selectedBooking)
                ->where('user_id', auth()->id())
                ->where('status_booking', 'completed')
                ->first();

            if (!$booking) {
                session()->flash('error', 'Booking tidak valid atau belum selesai.');
                $this->cancelForm();
                return;
            }

            if (!$booking->package || !$booking->package->mountain) {
                session()->flash('error', 'Data paket atau gunung tidak ditemukan.');
                $this->cancelForm();
                return;
            }

            $existingReview = Review::where('booking_id', $booking->id)->first();
            if ($existingReview) {
                session()->flash('error', 'Anda sudah memberikan review untuk booking ini.');
                $this->cancelForm();
                return;
            }

            Review::create([
                'user_id' => auth()->id(),
                'mountain_id' => $booking->package->mountain->id,
                'booking_id' => $booking->id,
                'rating' => $this->rating,
                'komentar' => trim($this->komentar),
                'is_approved' => false,
            ]);

            session()->flash('success', 'Review berhasil dikirim! Menunggu persetujuan admin.');
            
            $this->cancelForm();
            $this->resetPage();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            $this->cancelForm();
        }
    }

    public function render()
    {
        $userId = auth()->id();

        $reviews = Review::with(['mountain', 'booking.package.mountain'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(5);

        $bookingsCanReview = Booking::with('package.mountain')
            ->where('user_id', $userId)
            ->where('status_booking', 'completed')
            ->whereDoesntHave('review')
            ->latest()
            ->get()
            ->filter(function($booking) {
                return $booking->package && $booking->package->mountain;
            });

        $stats = [
            'total_reviews' => Review::where('user_id', $userId)->count(),
            'pending_reviews' => Review::where('user_id', $userId)->where('is_approved', false)->count(),
            'approved_reviews' => Review::where('user_id', $userId)->where('is_approved', true)->count(),
        ];

        return view('livewire.reviews.my-reviews', [
            'reviews' => $reviews,
            'bookingsCanReview' => $bookingsCanReview,
            'stats' => $stats,
        ]);
    }
}