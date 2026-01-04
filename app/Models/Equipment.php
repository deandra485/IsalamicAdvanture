<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'nama_peralatan',
        'deskripsi',
        'merk',
        'harga_sewa_perhari',
        'stok_tersedia',
        'kondisi',
        'spesifikasi',
        'is_available',
        'created_by',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'harga_sewa_perhari' => 'decimal:2',
        'stok_tersedia' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(EquipmentImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(EquipmentImage::class)->where('is_primary', true);
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_equipment')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper methods
    public function isAvailableForDates($startDate, $endDate, $quantity = 1)
    {
        $bookedQuantity = BookingItem::whereHas('booking', function($query) use ($startDate, $endDate) {
            $query->where('status_booking', '!=', 'cancelled')
                  ->where(function($q) use ($startDate, $endDate) {
                      $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
                        ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
                        ->orWhere(function($q2) use ($startDate, $endDate) {
                            $q2->where('tanggal_mulai', '<=', $startDate)
                               ->where('tanggal_selesai', '>=', $endDate);
                        });
                  });
        })->where('equipment_id', $this->id)->sum('quantity');

        return ($this->stok_tersedia - $bookedQuantity) >= $quantity;
    }

}