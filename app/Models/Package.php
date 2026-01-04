<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'mountain_id',
        'nama_paket',
        'deskripsi',
        'harga_paket',
        'durasi_hari',
        'max_peserta',
        'include_guide',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'include_guide' => 'boolean',
        'harga_paket' => 'decimal:2',
        'durasi_hari' => 'integer',
        'max_peserta' => 'integer',
    ];

    // Relationships
    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'package_equipment')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}