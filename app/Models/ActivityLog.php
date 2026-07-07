<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'action',
        'module',
        'description',
        'admin_id',
        'item_id',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public static function log($action, $module, $description, $adminId = null, $itemId = null, $oldValues = null, $newValues = null)
    {
        return self::create([
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'admin_id' => $adminId,
            'item_id' => $itemId,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
        ]);
    }
}

