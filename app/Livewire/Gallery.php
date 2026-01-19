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
                'url' => '/image/galeri/galeri5.jpg',
                'thumb' => '/image/galeri/galeri5.jpg',
                'title' => 'Mountain Landscape',
                'description' => 'Beautiful mountain view'
            ],
            [
                'id' => 2,
                'url' => '/image/galeri/galeri7.jpg',
                'thumb' => '/image/galeri/galeri7.jpg',
                'title' => 'Nature Trail',
                'description' => 'Peaceful nature walk'
            ],
            [
                'id' => 3,
                'url' => '/image/galeri/galeri8.jpg',
                'thumb' => '/image/galeri/galeri8.jpg',
                'title' => 'Sunset View',
                'description' => 'Amazing sunset colors'
            ],
            [
                'id' => 4,
                'url' => '/image/galeri/islamic.jpg',
                'thumb' => '/image/galeri/islamic.jpg',
                'title' => 'Forest Path',
                'description' => 'Green forest pathway'
            ],
            [
                'id' => 5,
                'url' => '/image/galeri/galeri6.jpg',
                'thumb' => '/image/galeri/galeri6.jpg',
                'title' => 'Lake Reflection',
                'description' => 'Crystal clear lake'
            ],
            [
                'id' => 6,
                'url' => '/image/galeri/galeri9.jpg',
                'thumb' => '/image/galeri/galeri9.jpg',
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