<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    use HasFactory;

    /**
     * ===============================
     * Mass Assignment
     * ===============================
     */
    protected $fillable = [
        'user_id',
        'package_id',
        'booking_type',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_hari',
        'total_biaya',
        'status_booking',
        'metode_pengambilan',
        'alamat_pengiriman',
        'catatan_customer',
        'catatan_admin',
        'confirmed_by',
    ];

    /**
     * ===============================
     * Casting
     * ===============================
     */
    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'durasi_hari'     => 'integer',
        'total_biaya'     => 'decimal:2',
    ];

    /**
     * ===============================
     * Appended Attributes
     * ===============================
     */
    protected $appends = [
        'booking_code',
        'total_peserta',
    ];

    /**
     * ===============================
     * Relationships
     * ===============================
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * ===============================
     * Accessors
     * ===============================
     */

    // Booking Code otomatis → TRX-00001
    public function getBookingCodeAttribute()
    {
        return $this->attributes['booking_code']
            ?? 'TRX-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    // Total peserta (fallback aman)
    public function getTotalPesertaAttribute()
    {
        if (isset($this->attributes['quantity'])) {
            return (int) $this->attributes['quantity'];
        }

        if ($this->relationLoaded('items')) {
            return $this->items->sum('quantity');
        }

        return 1;
    }

    /**
     * ===============================
     * Helper Methods
     * ===============================
     */
    public function isPending()
    {
        return $this->status_booking === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status_booking === 'confirmed';
    }

    public function isOngoing()
    {
        return $this->status_booking === 'ongoing';
    }

    public function isCompleted()
    {
        return $this->status_booking === 'completed';
    }

    public function canBeCancelled()
    {
        return in_array($this->status_booking, ['pending', 'confirmed']);
    }

    /**
     * ===============================
     * Model Events
     * ===============================
     */
    protected static function booted()
    {
        static::creating(function ($booking) {
            // Auto hitung durasi jika belum diisi
            if (!$booking->durasi_hari && $booking->tanggal_mulai && $booking->tanggal_selesai) {
                $booking->durasi_hari =
                    Carbon::parse($booking->tanggal_mulai)
                        ->diffInDays(Carbon::parse($booking->tanggal_selesai)) + 1;
            }
        });
    }
}
