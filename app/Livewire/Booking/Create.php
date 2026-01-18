<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\Equipment;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public Equipment $equipment;

    public int $quantity = 1;
    public int $durasi = 1;

    public string $tanggal_mulai;
    public string $tanggal_selesai;

    public function mount(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    public function addToCart()
    {
        $cart = session()->get('cart', []);

        $subtotal = $this->quantity * $this->durasi * $this->equipment->harga_sewa;

        $cart[] = [
            'equipment_id' => $this->equipment->id,

            // ⬇️ INI YANG MEMPERBAIKI ERROR
            'equipment' => [
                'nama_peralatan' => $this->equipment->nama_peralatan,
                'category' => [
                    'nama_kategori' => $this->equipment->category->nama_kategori ?? null,
                ],
                'primary_image' => [
                    'image_url' => $this->equipment->primaryImage->image_url ?? null,
                ],
            ],

            'quantity' => $this->quantity,
            'durasi' => $this->durasi,
            'harga_satuan' => $this->equipment->harga_sewa,
            'subtotal' => $subtotal,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
        ];

        session()->put('cart', $cart);

        $this->dispatch('cart-updated');
        session()->flash('success', 'Peralatan berhasil ditambahkan ke keranjang');

        return redirect()->route('booking.cart');
    }

    public function render()
    {
        return view('livewire.booking.create');
    }
}
