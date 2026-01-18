<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'jumlah_bayar',
        'metode_pembayaran',
        'payment_type',            // BARU
        'status_pembayaran',
        'tanggal_pembayaran',
        'bukti_pembayaran_url',
        'catatan',
        'verified_by',
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'tanggal_pembayaran' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Status Checkers
    public function isPending()
    {
        return $this->status_pembayaran === 'pending';
    }

    public function isVerified()
    {
        return $this->status_pembayaran === 'verified';
    }

    public function isRejected()
    {
        return $this->status_pembayaran === 'rejected';
    }

    // Payment Type Checkers
    public function isOnlinePayment()
    {
        return $this->payment_type === 'online';
    }

    public function isManualPayment()
    {
        return $this->payment_type === 'manual';
    }

    // Helper Methods
    public function getStatusBadgeColor()
    {
        return match($this->status_pembayaran) {
            'pending' => 'yellow',
            'verified' => 'green',
            'rejected' => 'red',
            'failed' => 'red',
            'refunded' => 'gray',
            default => 'gray'
        };
    }

    public function getPaymentTypeLabel()
    {
        return match($this->payment_type) {
            'online' => 'Transfer Online',
            'manual' => 'Pembayaran Manual',
            default => ucfirst($this->payment_type)
        };
    }

    public function getStatusLabel()
    {
        return match($this->status_pembayaran) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
            default => ucfirst($this->status_pembayaran)
        };
    }
}