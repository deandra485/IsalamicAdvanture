<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

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

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'total_biaya' => 'decimal:2',
        'durasi_hari' => 'integer',
    ];

    // Relationships
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

    // Helper methods
    public function isPending()
    {
        return $this->status_booking === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status_booking === 'confirmed';
    }

    public function isCompleted()
    {
        return $this->status_booking === 'completed';
    }

    public function canBeCancelled()
    {
        return in_array($this->status_booking, ['pending', 'confirmed']);
    }
}