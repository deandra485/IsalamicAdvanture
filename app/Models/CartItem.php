<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',       // 'equipment' atau 'package'
        'package_id',
        'equipment_id',
        'quantity',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Package (Paket Wisata)
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Relasi ke Equipment (Peralatan)
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}