<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'jumlah_bayar',
        'metode_pembayaran',
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

    /* ================= RELATIONSHIPS ================= */

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * 🔥 User pemilik payment (via booking)
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Booking::class,
            'id',        // PK di bookings
            'id',        // PK di users
            'booking_id',
            'user_id'
        );
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /* ================= HELPERS ================= */

    public function isPending(): bool
    {
        return $this->status_pembayaran === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->status_pembayaran === 'verified';
    }
}
