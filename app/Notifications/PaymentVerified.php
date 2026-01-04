<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentVerified extends Notification
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
            ->subject('Pembayaran Terverifikasi - SantriFund')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Pembayaran Anda telah diverifikasi.')
            ->line('Booking ID: #' . $this->booking->id)
            ->line('Status: ' . ucfirst($this->booking->status_booking))
            ->action('Lihat Detail', url('/bookings'))
            ->line('Booking Anda siap diproses!')
            ->line('Terima kasih!');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Pembayaran untuk booking #' . $this->booking->id . ' telah diverifikasi',
        ];
    }
}