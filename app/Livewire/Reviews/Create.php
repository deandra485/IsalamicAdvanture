<?php

namespace App\Livewire\Reviews;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;


#[Layout('layouts.app')]
class Create extends Component
{
    use WithFileUploads;

    public $booking;
    public $rating = 0;
    public $komentar = '';
    public $photos = [];

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'nullable|string|max:1000',
        'photos.*' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'rating.required' => 'Rating harus diisi',
        'rating.min' => 'Rating minimal 1 bintang',
        'rating.max' => 'Rating maksimal 5 bintang',
        'komentar.max' => 'Komentar maksimal 1000 karakter',
        'photos.*.image' => 'File harus berupa gambar',
        'photos.*.max' => 'Ukuran gambar maksimal 2MB',
    ];

    public function mount($bookingId)
    {
        // Load booking dengan package dan mountain
        $this->booking = Booking::with(['package.mountain', 'user'])
            ->where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->where('status_booking', 'completed')
            ->firstOrFail();

        // Cek apakah sudah ada review
        $existingReview = Review::where('booking_id', $bookingId)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            session()->flash('error', 'Anda sudah memberikan review untuk booking ini.');
            return redirect()->route('user.bookings.history');
        }
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:2048',
        ]);
    }

    public function removePhoto($index)
    {
        array_splice($this->photos, $index, 1);
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function submit()
    {
        $this->validate();

        try {
            $photoPaths = [];

            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $path = $photo->store('reviews', 'public');
                    $photoPaths[] = $path;
                }
            }

            // Ambil mountain_id dari package
            $mountainId = $this->booking->package->mountain_id ?? null;

            Review::create([
                'user_id' => auth()->id(),
                'mountain_id' => $mountainId,
                'booking_id' => $this->booking->id,
                'rating' => $this->rating,
                'komentar' => $this->komentar,
                'photos' => $photoPaths,
                'is_approved' => false,
            ]);

            session()->flash('success', 'Review berhasil dikirim dan menunggu persetujuan admin.');
            
            return redirect()->route('user.bookings.history');

        } catch (\Exception $e) {
            Log::error('Error creating review: ' . $e->getMessage());
            session()->flash('error', 'Gagal menyimpan review.');
        }
    }

    public function render()
    {
        return view('livewire.reviews.create');
    }
}