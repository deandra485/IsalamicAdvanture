<?php
// ==========================================
// APP/LIVEWIRE/EQUIPMENT/SHOW.PHP
// ==========================================

namespace App\Livewire\Equipment;

use App\Models\Equipment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\User;

#[layout('layouts.app')]
class Show extends Component
{
    public Equipment $equipment;
    public $quantity = 1;
    public $tanggalMulai;
    public $tanggalSelesai;
    public $durasi = 0;
    public $totalHarga = 0;
    public $availableStock = 0;
    public User $user;

    public function mount(Equipment $equipment)
    {
        $this->equipment = $equipment->load(['category', 'images']);
        $this->tanggalMulai = Carbon::tomorrow()->format('Y-m-d');
        $this->tanggalSelesai = Carbon::tomorrow()->addDays(2)->format('Y-m-d');
        $this->calculateDuration();
    }

    public function updatedTanggalMulai()
    {
        $this->calculateDuration();
    }

    public function updatedTanggalSelesai()
    {
        $this->calculateDuration();
    }

    public function updatedQuantity()
    {
        $this->calculateDuration();
    }

    public function calculateDuration()
    {
        if ($this->tanggalMulai && $this->tanggalSelesai) {
            $start = Carbon::parse($this->tanggalMulai);
            $end = Carbon::parse($this->tanggalSelesai);
            
            if ($end->gt($start)) {
                $this->durasi = $start->diffInDays($end) + 0;
                $this->totalHarga = $this->durasi * $this->equipment->harga_sewa_perhari * $this->quantity;
                
                // Check availability
                $this->availableStock = $this->equipment->stok_tersedia;
                if ($this->tanggalMulai && $this->tanggalSelesai) {
                    $booked = $this->equipment->isAvailableForDates($this->tanggalMulai, $this->tanggalSelesai, $this->quantity);
                    $this->availableStock = $booked ? $this->equipment->stok_tersedia : 0;
                }
            } else {
                $this->durasi = 0;
                $this->totalHarga = 0;
            }
        }
    }

    public function addToCart()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($this->quantity > $this->availableStock) {
            session()->flash('error', 'Stok tidak mencukupi untuk tanggal tersebut');
            return;
        }

        $cart = session()->get('cart', []);
        
        $cartKey = $this->equipment->id . '-' . $this->tanggalMulai . '-' . $this->tanggalSelesai;
        
        if (isset($cart[$cartKey])) {
    $cart[$cartKey]['type'] = 'equipment'; // 🔥 PAKSA ADA
    $cart[$cartKey]['quantity'] += $this->quantity;
    $cart[$cartKey]['durasi'] = $this->durasi;
    $cart[$cartKey]['harga_satuan'] = $this->equipment->harga_sewa_perhari;
    $cart[$cartKey]['subtotal'] =
        $cart[$cartKey]['quantity']
        * $cart[$cartKey]['durasi']
        * $cart[$cartKey]['harga_satuan'];
} else {
    $cart[$cartKey] = [
        'type' => 'equipment', // 🔥 WAJIB
        'equipment_id' => $this->equipment->id,
        'equipment' => $this->equipment->toArray(),
        'quantity' => $this->quantity,
        'tanggal_mulai' => $this->tanggalMulai,
        'tanggal_selesai' => $this->tanggalSelesai,
        'durasi' => $this->durasi,
        'harga_satuan' => $this->equipment->harga_sewa_perhari,
        'subtotal' => $this->totalHarga,
    ];
}

        
        session()->put('cart', $cart);
        
        $this->dispatch('cart-updated');
        session()->flash('success', 'Berhasil ditambahkan ke keranjang!');
        
        return redirect()->route('booking.cart');
    }

    public function render()
    {
        return view('livewire.equipment.show');
    }
}