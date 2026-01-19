<?php

namespace App\Livewire\Payment;

use App\Models\Booking;
use App\Models\User;
use App\Models\Payment;
use App\Notifications\PaymentReceived;
use App\Traits\HasFileUpload;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\PaymentStatus;

#[Layout('layouts.app')]
class Process extends Component
{
    use WithFileUploads, HasFileUpload;

    public Booking $booking;
    public $bukti_pembayaran;
    public ?string $catatan = null;
    public string $selectedMethod = 'transfer_bank';
    

    public array $bankAccounts = [
        'bca' => [
            'name' => 'Bank BCA',
            'account_number' => '4181414426',
            'account_name' => 'Amirudin Abdul Aziz',
            'logo' => '🏦',
        ],
    ];

    protected $rules = [
        'bukti_pembayaran' => 'required|image|max:2048',
        'catatan' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload',
        'bukti_pembayaran.image' => 'File harus berupa gambar',
        'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB',
    ];

    public function mount(Booking $booking): void
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (
            $booking->payment &&
            $booking->payment->status_pembayaran === 'verified'
        ) {
            session()->flash('info', 'Pembayaran sudah diverifikasi');
            redirect()->route('user.bookings.history')->send();
        }

        $this->booking = $booking->load('payment', 'items.equipment', 'package');
        $this->selectedMethod =
            $this->booking->payment->metode_pembayaran ?? 'transfer_bank';
    }

    public function selectMethod(string $method): void
    {
        $this->selectedMethod = $method;
    }

public function uploadPaymentProof()
{
    $this->validate();

    try {
        $path = $this->uploadImage($this->bukti_pembayaran, 'payments');

        $payment = Payment::updateOrCreate(
            [
                'booking_id' => $this->booking->id,
            ],
            [
                'jumlah_bayar' => $this->booking->total_biaya,
                'metode_pembayaran' => $this->selectedMethod,
                'status_pembayaran' => PaymentStatus::PENDING->value,
                'tanggal_pembayaran' => now(),
                'bukti_pembayaran_url' => $path,
                'catatan' => $this->catatan,
            ]
        );

        // Notifikasi admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new PaymentReceived($this->booking));
        }

        // Activity log
        \App\Models\ActivityLog::log(
            'update',
            'payments',
            $payment->id,
            'Customer uploaded payment proof for booking #' . $this->booking->id
        );

        session()->flash(
            'success',
            'Bukti pembayaran berhasil diupload, menunggu verifikasi admin.'
        );

        return redirect()->route('user.bookings.history');

    } catch (\Throwable $e) {
        report($e);
        session()->flash('error', 'Terjadi kesalahan saat mengupload bukti pembayaran.');
    }
}


    public function render()
    {
        return view('livewire.payment.process');
    }
}
