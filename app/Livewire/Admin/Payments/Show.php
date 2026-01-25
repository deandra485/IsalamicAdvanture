<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use App\Notifications\PaymentRejected;
use App\Notifications\PaymentVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Component;

#[Layout('layouts.admin')]
class Show extends Component
{
    public Payment $payment;
    
    public string $verificationNote = '';
    public string $rejectReason = '';
    public string $verificationMode = 'with_proof'; // 'with_proof' or 'manual_payment'

    /* ================= MOUNT ================= */

    public function mount(Payment $payment): void
    {
        $this->payment = $payment;
        $this->loadPaymentRelations();
    }

    /* ================= COMPUTED PROPERTIES ================= */

    #[Computed]
    public function bookingType()
    {
        return $this->payment->booking->booking_type;
    }

    #[Computed]
    public function hasEquipmentItems()
    {
        return $this->payment->booking->items->contains(fn($item) => $item->item_type === 'equipment');
    }

    #[Computed]
    public function hasPackageItems()
    {
        return $this->payment->booking->items->contains(fn($item) => $item->item_type === 'package');
    }

    #[Computed]
    public function itemsGroupedByType()
    {
        return $this->payment->booking->items->groupBy('item_type');
    }

    /* ================= PRIVATE METHODS ================= */

    private function loadPaymentRelations(): void
    {
        $this->payment->load([
            'booking' => function ($query) {
                $query->with([
                    'user',
                    'items' => function ($itemQuery) {
                        $itemQuery->with([
                            'equipment.category',
                            'package.mountain'
                        ]);
                    }
                ]);
            },
            'verifiedBy'
        ]);
    }

    private function refreshPayment(): void
    {
        $this->payment->refresh();
        $this->loadPaymentRelations();
    }

    /* ================= VERIFY PAYMENT ================= */

    public function verifyPayment(): void
    {
        // Validation rules based on verification mode
        $rules = [
            'verificationMode' => 'required|in:with_proof,manual_payment',
        ];

        if ($this->verificationMode === 'manual_payment') {
            $rules['verificationNote'] = 'required|string|min:20|max:500';
        } else {
            $rules['verificationNote'] = 'nullable|string|max:500';
        }

        $this->validate($rules, [
            'verificationMode.required' => 'Silakan pilih jenis verifikasi.',
            'verificationNote.required' => 'Catatan wajib diisi untuk pembayaran manual.',
            'verificationNote.min' => 'Catatan minimal 20 karakter untuk pembayaran manual.',
        ]);

        if (!$this->payment->isPending()) {
            session()->flash('error', 'Payment tidak dapat diverifikasi.');
            return;
        }

        // Check if proof is required but not available
        if ($this->verificationMode === 'with_proof' && !$this->payment->bukti_pembayaran_url) {
            session()->flash('error', 'Bukti pembayaran tidak tersedia. Gunakan opsi "Konfirmasi Pembayaran Manual" jika customer membayar langsung.');
            return;
        }

        try {
            DB::transaction(function () {
                // Determine payment type
                $paymentType = $this->verificationMode === 'manual_payment' ? 'manual' : 'online';
                
                // Prepare catatan
                $catatan = $this->verificationNote ?: null;

                // Update payment
                $this->payment->update([
                    'status_pembayaran' => 'verified',
                    'payment_type' => $paymentType,
                    'verified_by' => Auth::id(),
                    'catatan' => $catatan,
                ]);

                // Update booking status
                $this->payment->booking->update([
                    'status_booking' => 'confirmed',
                    'confirmed_by' => Auth::id(),
                ]);

                // Process based on booking type
                if ($this->bookingType === 'equipment') {
                    $this->processEquipmentVerification();
                } else {
                    $this->processPackageVerification();
                }

                // Send notification
                if ($this->payment->booking->user) {
                    $this->payment->booking->user->notify(
                        new PaymentVerified($this->payment->booking)
                    );
                }
            });

            $successMessage = $this->verificationMode === 'manual_payment' 
                ? 'Pembayaran manual berhasil dikonfirmasi dan customer telah diberitahu.'
                : 'Payment berhasil diverifikasi dan customer telah diberitahu.';

            session()->flash('success', $successMessage);
            
            $this->refreshPayment();
            $this->reset(['verificationNote', 'verificationMode']);
            $this->verificationMode = 'with_proof'; // Reset to default
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function processEquipmentVerification(): void
    {
        // Update equipment stock if needed
        foreach ($this->payment->booking->items as $item) {
            if ($item->item_type === 'equipment' && $item->equipment) {
                // Optionally reduce stock here
                // $item->equipment->decrement('stok_tersedia', $item->quantity);
            }
        }
    }

    private function processPackageVerification(): void
    {
        // Process package-specific logic
        foreach ($this->payment->booking->items as $item) {
            if ($item->item_type === 'package' && $item->package) {
                // Add any package-specific processing here
                // e.g., create guide assignment, send itinerary, etc.
            }
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
                    'status_pembayaran' => 'failed',
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
            
            $this->refreshPayment();
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

        $filename = 'bukti_pembayaran_' . $this->payment->booking->kode_booking . '_' . now()->format('Ymd_His') . '.' . pathinfo($this->payment->bukti_pembayaran_url, PATHINFO_EXTENSION);

        return response()->download(
            storage_path('app/public/' . $this->payment->bukti_pembayaran_url),
            $filename
        );
    }

    /* ================= HELPER METHODS ================= */

    public function getItemTypeLabel(string $type): string
    {
        return match($type) {
            'equipment' => 'Equipment Rental',
            'package' => 'Package Booking',
            default => ucfirst($type)
        };
    }

    public function getItemIcon(string $type): string
    {
        return match($type) {
            'equipment' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
            'package' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
            default => ''
        };
    }

    /* ================= RENDER ================= */

    public function render()
    {
        return view('livewire.admin.payments.show');
    }
}