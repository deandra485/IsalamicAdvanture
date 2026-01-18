<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreated extends Notification
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
    $mail = (new MailMessage)
        ->subject('Booking Berhasil Dibuat - Islamic Adventure')
        ->greeting('Halo ' . $notifiable->name . '!')
        ->line('Booking Anda telah berhasil dibuat.')
        ->line('Nomor Booking: #' . $this->booking->id)
        ->line('Total Biaya: Rp ' . number_format($this->booking->total_biaya, 0, ',', '.'));

    // ⬇️ TAMBAHKAN KONDISI INI
    if ($this->booking->tanggal_mulai && $this->booking->tanggal_selesai) {
        $mail->line(
            'Tanggal: ' .
            $this->booking->tanggal_mulai->format('d M Y') .
            ' - ' .
            $this->booking->tanggal_selesai->format('d M Y')
        );
    } else {
        $mail->line('Jenis Booking: Paket (tanpa tanggal sewa)');
    }

    return $mail
        ->action('Lihat Detail Booking', url('/bookings'))
        ->line('Silakan lakukan pembayaran untuk melanjutkan pesanan Anda.')
        ->line('Terima kasih telah menggunakan SantriFund!');
}


    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Booking #' . $this->booking->id . ' berhasil dibuat',
            'total_biaya' => $this->booking->total_biaya,
        ];
    }
}