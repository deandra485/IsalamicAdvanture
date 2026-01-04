<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\BookingCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Checkout extends Component
{
    public array $cart = [];
    public string $metodePengambilan = 'pickup';
    public ?string $alamatPengiriman = null;
    public ?string $catatanCustomer = null;
    public string $metodePembayaran = 'transfer_bank';

    public User $user;

    protected $rules = [
        'metodePengambilan' => 'required|in:pickup,delivery',
        'alamatPengiriman' => 'required_if:metodePengambilan,delivery',
        'metodePembayaran' => 'required|in:transfer_bank,e_wallet,cod',
    ];

    protected $messages = [
        'alamatPengiriman.required_if' =>
            'Alamat pengiriman wajib diisi untuk metode delivery',
    ];

    public function mount(): void
    {
        $this->user = Auth::user();

        $this->cart = session()->get('cart', []);

        if (empty($this->cart)) {
        $this->redirectRoute('user.cart');
        }

        if (!empty($this->user->alamat)) {
            $this->alamatPengiriman = $this->user->alamat;
        }
    }

    public function processCheckout()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $tanggalMulai = collect($this->cart)->min('tanggal_mulai');
            $tanggalSelesai = collect($this->cart)->max('tanggal_selesai');

            $durasi = \Carbon\Carbon::parse($tanggalMulai)
                ->diffInDays($tanggalSelesai) + 1;

            $booking = Booking::create([
                'user_id' => $this->user->id,
                'booking_type' => 'equipment',
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'durasi_hari' => $durasi,
                'total_biaya' => collect($this->cart)->sum('subtotal'),
                'status_booking' => 'pending',
                'metode_pengambilan' => $this->metodePengambilan,
                'alamat_pengiriman' =>
                    $this->metodePengambilan === 'delivery'
                        ? $this->alamatPengiriman
                        : null,
                'catatan_customer' => $this->catatanCustomer,
            ]);

            foreach ($this->cart as $item) {
                BookingItem::create([
                    'booking_id' => $booking->id,
                    'equipment_id' => $item['equipment_id'],
                    'quantity' => $item['quantity'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            Payment::create([
                'booking_id' => $booking->id,
                'jumlah_bayar' => $booking->total_biaya,
                'metode_pembayaran' => $this->metodePembayaran,
                'status_pembayaran' => 'pending',
            ]);

            $this->user->notify(new BookingCreated($booking));

            session()->forget('cart');

            DB::commit();

            session()->flash('success', 'Pesanan berhasil dibuat');

            return redirect()->route('user.payment.process', $booking);

        } catch (\Throwable $e) {
            DB::rollBack();

            session()->flash(
                'error',
                'Terjadi kesalahan: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.booking.checkout');
    }
}
