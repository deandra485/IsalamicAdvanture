<?php

namespace App\Livewire\Packages;

use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Package $package;
    public int $quantity = 1;
    public ?User $user = null;
    public int $totalPrice = 0;

    // Tambahan untuk Tanggal
    public $tanggalMulai;
    public $tanggalSelesai; // Ini otomatis dihitung
    public $minDate; // Supaya gak bisa pilih tanggal masa lalu

    public function mount(Package $package)
    {
        $this->user = Auth::user();
        $this->package = Package::with(['mountain', 'equipment'])
            ->where('is_active', true)
            ->findOrFail($package->id);

        $this->calculateTotal();
        
        // Set minimal booking adalah H+1 (besok), bisa diubah sesuai kebutuhan
        $this->minDate = Carbon::tomorrow()->format('Y-m-d');
    }

    // Fungsi otomatis jalan setiap kali user ganti tanggal
    public function updatedTanggalMulai($value)
    {
        if ($value) {
            // Rumus: Tanggal Mulai + (Durasi - 1 hari)
            // Contoh: Mulai tgl 1, Durasi 3 hari => Selesai tgl 3 (bukan tgl 4)
            $start = Carbon::parse($value);
            $end = $start->copy()->addDays($this->package->durasi_hari - 1);
            
            $this->tanggalSelesai = $end->format('Y-m-d');
        } else {
            $this->tanggalSelesai = null;
        }
    }

    public function calculateTotal()
    {
        $this->totalPrice = $this->package->harga_paket * $this->quantity;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
        $this->calculateTotal();
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->calculateTotal();
        }
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Validasi Wajib Pilih Tanggal
        $this->validate([
            'tanggalMulai' => 'required|date|after_or_equal:today',
        ], [
            'tanggalMulai.required' => 'Wajib pilih tanggal pendakian dulu, Bang!',
            'tanggalMulai.after_or_equal' => 'Tanggalnya sudah lewat, pilih tanggal lain.',
        ]);

        $cart = session()->get('cart', []);
        
        // Key unik sekarang gabungan ID Paket + Tanggal
        // Jadi user bisa pesan paket sama tapi beda tanggal
        $key = 'package-' . $this->package->id . '-' . $this->tanggalMulai;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $this->quantity;
            $cart[$key]['subtotal'] = $cart[$key]['quantity'] * $cart[$key]['harga_satuan'];
        } else {
            $cart[$key] = [
                'type' => 'package',
                'package_id' => $this->package->id,
                'package' => $this->package->toArray(),
                'quantity' => $this->quantity,
                'harga_satuan' => $this->package->harga_paket,
                'subtotal' => $this->totalPrice,
                // Data Tanggal Masuk Sini
                'tanggal_mulai' => $this->tanggalMulai,
                'tanggal_selesai' => $this->tanggalSelesai,
                'durasi' => $this->package->durasi_hari . ' Hari'
            ];
        }

        session()->put('cart', $cart);
        session()->flash('success', 'Siap! Paket & Tanggal berhasil disimpan.');
        
        $this->dispatch('cart-updated'); 
        
        // Reset (Opsional, kalau mau user tetap di halaman buat nambah lagi)
        // $this->quantity = 1;
        // $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.packages.show');
    }
}