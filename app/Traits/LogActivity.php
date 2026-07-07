<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

trait LogActivity
{
    protected function logActivity($action, $module, $description, $itemId = null, $oldValues = null, $newValues = null)
    {
        $request = request();
        $adminId = $request->session()->get('auth_user')['id'] ?? null;

        ActivityLog::log(
            action: $action,
            module: $module,
            description: $description,
            adminId: $adminId,
            itemId: $itemId,
            oldValues: $oldValues,
            newValues: $newValues
        );
    }
}
