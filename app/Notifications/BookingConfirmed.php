<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification
{
    use Queueable;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['database']; 
        // tambahkan 'mail' kalau mau email
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'status'     => $this->booking->status_booking,
            'message'    => 'Booking Anda telah dikonfirmasi oleh admin.',
        ];
    }

    // OPTIONAL kalau mau email
    /*
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Dikonfirmasi')
            ->line('Booking Anda telah dikonfirmasi.')
            ->action('Lihat Booking', url('/user/bookings'))
            ->line('Terima kasih.');
    }
    */
}
