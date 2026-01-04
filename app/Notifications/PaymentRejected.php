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
            ->subject('Payment Rejected - Order #' . $this->payment->order->order_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your payment could not be verified.')
            ->line('Order Number: **' . $this->payment->order->order_number . '**')
            ->line('Transaction ID: ' . $this->payment->transaction_id)
            ->line('Amount: Rp ' . number_format($this->payment->amount, 0, ',', '.'))
            ->line('**Reason:** ' . $this->payment->rejection_reason)
            ->line('Please submit a new payment with the correct information or contact our support team for assistance.')
            ->action('Retry Payment', route('orders.show', $this->payment->order))
            ->line('We apologize for any inconvenience caused.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Payment Rejected',
            'message' => 'Your payment for order #' . $this->payment->order->order_number . ' has been rejected.',
            'type' => 'payment_rejected',
            'payment_id' => $this->payment->id,
            'order_id' => $this->payment->order_id,
            'amount' => $this->payment->amount,
            'reason' => $this->payment->rejection_reason,
            'action_url' => route('orders.show', $this->payment->order),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'order_number' => $this->payment->order->order_number,
            'amount' => $this->payment->amount,
            'reason' => $this->payment->rejection_reason,
        ];
    }
}