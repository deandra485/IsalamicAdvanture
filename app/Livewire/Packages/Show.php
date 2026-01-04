<?php

namespace App\Livewire\Packages;

use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Package $package;
    public int $quantity = 1;
    public ?User $user = null;

    public function mount(Package $package)
    {
        $this->user = Auth::user();

        $this->package = Package::with(['mountain', 'equipment'])
            ->where('is_active', true)
            ->findOrFail($package->id);
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        if (!$this->user) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk menambahkan paket ke keranjang.');
            return redirect()->route('login');
        }

        $cartItem = $this->user
            ->cartItems()
            ->where('package_id', $this->package->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $this->quantity);
            session()->flash('success', 'Jumlah paket di keranjang berhasil diperbarui!');
        } else {
            $this->user->cartItems()->create([
                'package_id' => $this->package->id,
                'quantity' => $this->quantity,
            ]);
            session()->flash('success', 'Paket berhasil ditambahkan ke keranjang!');
        }

        $this->dispatch('cart-updated');
        $this->quantity = 1;
    }

    public function render()
    {
        return view('livewire.packages.show');
    }
}
