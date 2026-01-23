<?php

namespace App\Livewire\Booking;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache; // 1. Tambahkan Facade Cache

#[Layout('layouts.app')]
class Cart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->loadCart();
    }

    // Fungsi untuk memuat data
    private function loadCart()
    {
        // Ambil data session saat ini (untuk tamu atau data baru sebelum login)
        $sessionCart = session()->get('cart', []);

        if (Auth::check()) {
            $userId = Auth::id();
            $cacheKey = 'user_cart_' . $userId;
            
            // Ambil data dari Cache (penyimpanan file server)
            $cachedCart = Cache::get($cacheKey, []);

            // LOGIKA PENGGABUNGAN:
            // Jika ada barang di session (baru ditambah saat belum login),
            // kita jadikan itu yang utama dan simpan ke cache.
            if (!empty($sessionCart)) {
                $this->cart = $sessionCart;
                // Simpan ke cache agar sinkron, durasi 30 hari
                Cache::put($cacheKey, $this->cart, now()->addDays(30));
                
                // Opsional: Kosongkan session agar tidak duplikat logika
                // session()->forget('cart'); 
            } else {
                // Jika session kosong, ambil dari simpanan Cache user
                $this->cart = $cachedCart;
                // Update session buat jaga-jaga
                session()->put('cart', $this->cart);
            }
        } else {
            // Jika tamu, murni pakai session
            $this->cart = $sessionCart;
        }
    }

    // Fungsi Update Sentral
    private function saveCartState()
    {
        // 1. Selalu update Session (untuk UX cepat)
        session()->put('cart', $this->cart);

        // 2. Jika Login, simpan juga ke Cache File Server
        if (Auth::check()) {
            $userId = Auth::id();
            // Simpan selama 30 Hari
            Cache::put('user_cart_' . $userId, $this->cart, now()->addDays(30));
        }

        $this->dispatch('cart-updated');
    }

    public function removeItem($key)
    {
        unset($this->cart[$key]);
        $this->saveCartState(); // Panggil helper
        session()->flash('success', 'Item berhasil dihapus dari keranjang');
    }

    public function updateQuantity($key, $quantity)
    {
        if ($quantity < 1) {
            return $this->removeItem($key);
        }

        if (isset($this->cart[$key])) {
            $this->cart[$key]['quantity'] = $quantity;
            $this->cart[$key]['subtotal'] = $quantity * $this->cart[$key]['durasi'] * $this->cart[$key]['harga_satuan'];
            
            $this->saveCartState(); // Panggil helper
        }
    }

    public function clearCart()
    {
        $this->cart = [];
        
        // Hapus dari session
        session()->forget('cart');

        // Hapus dari Cache jika login
        if (Auth::check()) {
            Cache::forget('user_cart_' . Auth::id());
        }

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