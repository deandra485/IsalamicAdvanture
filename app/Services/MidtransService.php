<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($booking)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'BOOKING-' . $booking->id . '-' . time(),
                'gross_amount' => (int) $booking->total_biaya,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
                'phone' => $booking->user->no_telepon,
            ],
            'item_details' => $booking->items->map(function($item) {
                return [
                    'id' => $item->equipment_id,
                    'price' => (int) $item->harga_satuan,
                    'quantity' => $item->quantity,
                    'name' => $item->equipment->nama_peralatan,
                ];
            })->toArray(),
        ];

        return Snap::createTransaction($params);
    }

    public function getSnapToken($booking)
    {
        $transaction = $this->createTransaction($booking);
        return $transaction->token;
    }
}