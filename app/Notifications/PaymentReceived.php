<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bukti Pembayaran Diterima - SantriFund')
            ->greeting('Admin,')
            ->line('Bukti pembayaran baru telah diupload.')
            ->line('Booking ID: #' . $this->booking->id)
            ->line('Customer: ' . $this->booking->user->name)
            ->line('Total: Rp ' . number_format($this->booking->total_biaya, 0, ',', '.'))
            ->action('Verifikasi Pembayaran', url('/admin/payments'))
            ->line('Silakan verifikasi pembayaran ini.');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'customer_name' => $this->booking->user->name,
            'message' => 'Pembayaran baru perlu diverifikasi',
        ];
    }
}
