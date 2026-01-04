<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gunung',
        'lokasi',
        'ketinggian',
        'tingkat_kesulitan',
        'deskripsi',
        'image_url',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ketinggian' => 'integer',
    ];

    // Relationships
    public function hikingRoutes()
    {
        return $this->hasMany(HikingRoute::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper methods
    public function averageRating()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating');
    }

    public function totalReviews()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }
}