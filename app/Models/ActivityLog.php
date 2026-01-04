<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action_type',
        'table_name',
        'record_id',
        'description',
    ];

    protected $casts = [
        'record_id' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Static helper
    public static function log($action, $table, $recordId, $description = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'action_type' => $action,
            'table_name' => $table,
            'record_id' => $recordId,
            'description' => $description,
        ]);
    }
}