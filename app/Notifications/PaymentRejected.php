<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pembayaran Ditolak - Booking #' . $this->payment->booking->id)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Mohon maaf, bukti pembayaran Anda tidak dapat kami verifikasi.')
            ->line('Nomor Booking: #' . $this->payment->booking->id)
            ->line('Jumlah: Rp ' . number_format($this->payment->jumlah_bayar, 0, ',', '.'))
            ->line('Alasan: ' . ($this->payment->catatan ?: '-'))
            ->line('Silakan upload ulang bukti pembayaran yang benar atau hubungi tim support kami.')
            ->action('Lihat Booking', route('user.bookings.show', $this->payment->booking))
            ->line('Terima kasih!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pembayaran Ditolak',
            'message' => 'Pembayaran untuk booking #' . $this->payment->booking->id . ' ditolak.',
            'type' => 'payment_rejected',
            'payment_id' => $this->payment->id,
            'booking_id' => $this->payment->booking_id,
            'amount' => $this->payment->jumlah_bayar,
            'reason' => $this->payment->catatan,
            'action_url' => route('user.bookings.show', $this->payment->booking),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'booking_id' => $this->payment->booking_id,
            'amount' => $this->payment->jumlah_bayar,
            'reason' => $this->payment->catatan,
        ];
    }
}
