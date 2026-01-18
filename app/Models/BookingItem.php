<?php
// ==========================================
// APP/MODELS/BOOKINGITEM.PHP
// ==========================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'item_type',           // BARU: 'equipment' atau 'package'
        'equipment_id',
        'package_id',          // BARU
        'quantity',
        'harga_satuan',
        'subtotal',
        'tanggal_mulai',       // BARU
        'tanggal_selesai',     // BARU
    ];

    protected $casts = [
        'quantity' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tanggal_mulai' => 'date',      // BARU
        'tanggal_selesai' => 'date',    // BARU
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Accessor untuk mendapatkan item (equipment atau package)
    public function getItemAttribute()
    {
        return $this->item_type === 'package' ? $this->package : $this->equipment;
    }

    // Accessor untuk mendapatkan nama item
    public function getItemNameAttribute()
    {
        if ($this->item_type === 'package') {
            return $this->package->nama_paket ?? 'Unknown Package';
        }
        return $this->equipment->nama_peralatan ?? 'Unknown Equipment';
    }

    // Accessor untuk mendapatkan gambar item
    public function getItemImageAttribute()
    {
        if ($this->item_type === 'package') {
            return $this->package->image ?? null;
        }
        return $this->equipment->primary_image ?? null;
    }

    // Helper method untuk check apakah item adalah package
    public function isPackage()
    {
        return $this->item_type === 'package';
    }

    // Helper method untuk check apakah item adalah equipment
    public function isEquipment()
    {
        return $this->item_type === 'equipment';
    }
}