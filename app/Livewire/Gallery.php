<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[layout('layouts.app')]
class Gallery extends Component
{
    use WithFileUploads;

    public $images = [];
    public $selectedImage = null;
    public $showModal = false;

    public function mount()
    {
        // Contoh data gambar - ganti dengan data dari database Anda
        $this->images = [
            [
                'id' => 1,
                'url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800',
                'thumb' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400',
                'title' => 'Mountain Landscape',
                'description' => 'Beautiful mountain view'
            ],
            [
                'id' => 2,
                'url' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800',
                'thumb' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=400',
                'title' => 'Nature Trail',
                'description' => 'Peaceful nature walk'
            ],
            [
                'id' => 3,
                'url' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800',
                'thumb' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=400',
                'title' => 'Sunset View',
                'description' => 'Amazing sunset colors'
            ],
            [
                'id' => 4,
                'url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800',
                'thumb' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400',
                'title' => 'Forest Path',
                'description' => 'Green forest pathway'
            ],
            [
                'id' => 5,
                'url' => 'https://images.unsplash.com/photo-1426604966848-d7adac402bff?w=800',
                'thumb' => 'https://images.unsplash.com/photo-1426604966848-d7adac402bff?w=400',
                'title' => 'Lake Reflection',
                'description' => 'Crystal clear lake'
            ],
            [
                'id' => 6,
                'url' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800',
                'thumb' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=400',
                'title' => 'Ocean Waves',
                'description' => 'Peaceful ocean scene'
            ],
        ];
    }

    public function openImage($imageId)
    {
        $this->selectedImage = collect($this->images)->firstWhere('id', $imageId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedImage = null;
    }

    public function nextImage()
    {
        $currentIndex = collect($this->images)->search(fn($img) => $img['id'] === $this->selectedImage['id']);
        $nextIndex = ($currentIndex + 1) % count($this->images);
        $this->selectedImage = $this->images[$nextIndex];
    }

    public function previousImage()
    {
        $currentIndex = collect($this->images)->search(fn($img) => $img['id'] === $this->selectedImage['id']);
        $previousIndex = ($currentIndex - 1 + count($this->images)) % count($this->images);
        $this->selectedImage = $this->images[$previousIndex];
    }

    public function render()
    {
        return view('livewire.gallery');
    }
}