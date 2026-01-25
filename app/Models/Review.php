<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mountain_id',
        'booking_id',
        'rating',
        'komentar',
        'photos',
        'is_approved',
        'approved_by',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
        'photos' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    // Accessors
    public function getPhotoUrlsAttribute()
    {
        if (empty($this->photos)) {
            return [];
        }

        return collect($this->photos)->map(function ($photo) {
            return asset('storage/' . $photo);
        })->toArray();
    }
}