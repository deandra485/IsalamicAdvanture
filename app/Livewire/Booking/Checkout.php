<?php
// ==========================================
// APP/LIVEWIRE/BOOKING/CHECKOUT.PHP
// ==========================================

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\BookingItem;
use Livewire\Attributes\Layout;
use App\Models\Payment;
use App\Notifications\BookingCreated;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class Checkout extends Component
{
    public $cart = [];
    public $metodePengambilan = 'pickup';
    public $alamatPengiriman = '';
    public $catatanCustomer = '';
    public $metodePembayaran = 'transfer_bank';

    protected $rules = [
        'metodePengambilan' => 'required|in:pickup,delivery',
        'alamatPengiriman' => 'required_if:metodePengambilan,delivery',
        'metodePembayaran' => 'required|in:transfer_bank,e_wallet,cod',
    ];

    protected $messages = [
        'alamatPengiriman.required_if' => 'Alamat pengiriman wajib diisi untuk metode delivery',
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        
        if (empty($this->cart)) {
            return redirect()->route('booking.cart');
        }

        // Set default alamat from user
        if (auth()->user()->alamat) {
            $this->alamatPengiriman = auth()->user()->alamat;
        }
    }

    public function processCheckout()
    {
        $this->validate();

        // ⬇️ WAJIB ADA DI SINI
        $hasEquipment = collect($this->cart)
        ->contains(fn ($item) => $item['type'] === 'equipment');

        DB::beginTransaction();
        
        try {
            // Calculate dates
            $tanggalMulai = null;
            $tanggalSelesai = null;
            $durasi = null;

    if ($hasEquipment) {
    $dates = collect($this->cart)
        ->filter(fn ($item) =>
            $item['type'] === 'equipment' &&
            isset($item['tanggal_mulai'], $item['tanggal_selesai'])
        )
        ->map(fn ($item) => [
            'start' => $item['tanggal_mulai'],
            'end' => $item['tanggal_selesai'],
        ]);

    if ($dates->isEmpty()) {
        throw new \Exception('Tanggal booking tidak ditemukan');
    }

    $tanggalMulai = $dates->min('start');
    $tanggalSelesai = $dates->max('end');
    $durasi = \Carbon\Carbon::parse($tanggalMulai)
        ->diffInDays($tanggalSelesai) + 1;
}


            // Create Booking
            $booking = Booking::create([
    'user_id' => auth()->id(),
    'booking_type' => $hasEquipment ? 'equipment' : 'package',

    'tanggal_mulai' => $tanggalMulai,
    'tanggal_selesai' => $tanggalSelesai,
    'durasi_hari' => $durasi,

    'total_biaya' => collect($this->cart)->sum('subtotal'),
    'status_booking' => 'pending',
    'metode_pengambilan' => $this->metodePengambilan,
    'alamat_pengiriman' => $this->metodePengambilan === 'delivery'
        ? $this->alamatPengiriman
        : null,
    'catatan_customer' => $this->catatanCustomer,
]);


           foreach ($this->cart as $item) {

            BookingItem::create([
                'booking_id'      => $booking->id,
                'item_type'       => $item['type'], // equipment / package

                'equipment_id'    => $item['type'] === 'equipment'
                                        ? $item['equipment_id']
                                        : null,

                'package_id'      => $item['type'] === 'package'
                                        ? $item['package_id']
                                        : null,

                'quantity'        => $item['quantity'],
                'harga_satuan'    => $item['harga_satuan'],
                'subtotal'        => $item['subtotal'],

                'tanggal_mulai'   => $item['type'] === 'equipment'
                                        ? $item['tanggal_mulai']
                                        : null,

                'tanggal_selesai' => $item['type'] === 'equipment'
                                        ? $item['tanggal_selesai']
                                        : null,
            ]);
        }


            // Create Payment Record
            Payment::create([
                'booking_id' => $booking->id,
                'jumlah_bayar' => $booking->total_biaya,
                'metode_pembayaran' => $this->metodePembayaran,
                'status_pembayaran' => 'pending',
            ]);

            // Log Activity
            \App\Models\ActivityLog::log(
                'create',
                'bookings',
                $booking->id,
                'Customer membuat booking baru'
            );

            // Send Notification
            auth()->user()->notify(new BookingCreated($booking));

            // Clear Cart
            session()->forget('cart');

            DB::commit();

            session()->flash('success', 'Pesanan berhasil dibuat!');
            return redirect()->route('user.payment.process', $booking);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.booking.checkout');
    }
}
