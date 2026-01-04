<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingReminder extends Notification
{
    use Queueable;

    protected $booking;
    protected $type; // 'pickup' or 'return'

    public function __construct(Booking $booking, $type = 'pickup')
    {
        $this->booking = $booking;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Pengingat Booking - SantriFund')
            ->greeting('Halo ' . $notifiable->name . '!');

        if ($this->type === 'pickup') {
            $message->line('Booking Anda akan dimulai besok!')
                    ->line('Tanggal Pengambilan: ' . $this->booking->tanggal_mulai->format('d M Y'))
                    ->line('Jangan lupa untuk mengambil peralatan Anda.');
        } else {
            $message->line('Booking Anda akan berakhir besok!')
                    ->line('Tanggal Pengembalian: ' . $this->booking->tanggal_selesai->format('d M Y'))
                    ->line('Jangan lupa untuk mengembalikan peralatan tepat waktu.');
        }

        return $message->action('Lihat Detail', url('/bookings'))
                       ->line('Terima kasih!');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'type' => $this->type,
            'message' => $this->type === 'pickup' 
                ? 'Pengambilan besok untuk booking #' . $this->booking->id
                : 'Pengembalian besok untuk booking #' . $this->booking->id,
        ];
    }
}