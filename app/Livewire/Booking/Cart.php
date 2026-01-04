<?php
// ==========================================
// APP/LIVEWIRE/BOOKING/CART.PHP
// ==========================================

namespace App\Livewire\Booking;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[layout('layouts.app')]
class Cart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function removeItem($key)
    {
        $cart = session()->get('cart', []);
        unset($cart[$key]);
        session()->put('cart', $cart);
        
        $this->cart = $cart;
        $this->dispatch('cart-updated');
        session()->flash('success', 'Item berhasil dihapus dari keranjang');
    }

    public function updateQuantity($key, $quantity)
    {
        if ($quantity < 1) {
            return $this->removeItem($key);
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            $cart[$key]['subtotal'] = $quantity * $cart[$key]['durasi'] * $cart[$key]['harga_satuan'];
            session()->put('cart', $cart);
            
            $this->cart = $cart;
            $this->dispatch('cart-updated');
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->cart = [];
        $this->dispatch('cart-updated');
        session()->flash('success', 'Keranjang berhasil dikosongkan');
    }

    public function getTotal()
    {
        return collect($this->cart)->sum('subtotal');
    }

    public function render()
    {
        return view('livewire.booking.cart');
    }
}