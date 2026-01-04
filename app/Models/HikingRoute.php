<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HikingRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'mountain_id',
        'nama_jalur',
        'tingkat_kesulitan',
        'estimasi_waktu_hari',
        'jarak_km',
        'deskripsi_jalur',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'estimasi_waktu_hari' => 'integer',
        'jarak_km' => 'decimal:2',
    ];

    // Relationships
    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }
}