<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use App\Notifications\PaymentRejected;
use App\Notifications\PaymentVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Show extends Component
{
    public Payment $payment;
    
    public string $verificationNote = '';
    public string $rejectReason = '';

    /* ================= MOUNT ================= */

    public function mount(Payment $payment): void
    {
        $this->payment = $payment;

        $this->payment->load([
        'booking.user',
        'booking.package',
        'booking.items.product',
        'verifiedBy'
        ]);
    }

    /* ================= VERIFY PAYMENT ================= */

    public function verifyPayment(): void
    {
        $this->validate([
            'verificationNote' => 'nullable|string|max:500',
        ]);

        if (!$this->payment->isPending()) {
            session()->flash('error', 'Payment tidak dapat diverifikasi.');
            return;
        }

        try {
            DB::transaction(function () {
                // Update payment
                $this->payment->update([
                    'status_pembayaran' => 'verified',
                    'verified_by' => Auth::id(),
                    'catatan' => $this->verificationNote,
                ]);

                // Update booking status
                $this->payment->booking->update([
                    'status_booking' => 'confirmed',
                    'confirmed_by' => Auth::id(),
                ]);

                // Send notification
                if ($this->payment->booking->user) {
                    $this->payment->booking->user->notify(
                        new PaymentVerified($this->payment->booking)
                    );
                }
            });

            session()->flash('success', 'Payment berhasil diverifikasi dan customer telah diberitahu.');
            
            // Refresh payment
            $this->payment->refresh();
            $this->reset(['verificationNote']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /* ================= REJECT PAYMENT ================= */

    public function rejectPayment(): void
    {
        $this->validate([
            'rejectReason' => 'required|string|min:10|max:500',
        ], [
            'rejectReason.required' => 'Alasan penolakan wajib diisi.',
            'rejectReason.min' => 'Alasan penolakan minimal 10 karakter.',
            'rejectReason.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        if (!$this->payment->isPending()) {
            session()->flash('error', 'Payment tidak dapat ditolak.');
            return;
        }

        try {
            DB::transaction(function () {
                // Update payment
                $this->payment->update([
                    'status_pembayaran' => 'rejected',
                    'verified_by' => Auth::id(),
                    'catatan' => $this->rejectReason,
                ]);

                // Update booking status
                $this->payment->booking->update([
                    'status_booking' => 'cancelled',
                ]);

                // Send notification
                if ($this->payment->booking->user) {
                    $this->payment->booking->user->notify(
                        new PaymentRejected($this->payment)
                    );
                }
            });

            session()->flash('success', 'Payment berhasil ditolak dan customer telah diberitahu.');
            
            // Refresh payment
            $this->payment->refresh();
            $this->reset(['rejectReason']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /* ================= DOWNLOAD PROOF ================= */

    public function downloadProof()
    {
        if (!$this->payment->bukti_pembayaran_url || !Storage::disk('public')->exists($this->payment->bukti_pembayaran_url)) {
            session()->flash('error', 'Bukti pembayaran tidak ditemukan.');
            return null;
        }

        return response()->download(
            storage_path('app/public/' . $this->payment->bukti_pembayaran_url),
            'bukti_pembayaran_' . $this->payment->booking->kode_booking . '.jpg'
        );
    }

    /* ================= RENDER ================= */

    public function render()
    {
        return view('livewire.admin.payments.show');
    }
}