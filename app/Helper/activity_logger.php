<?php


use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if(!function_exists('logActivity')) {
    function logActivity($action, $task = null, $oldValues = null, $newValues = null)
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'task_id'    => $task?->id,
            'action'     => $action,
            'old_values' => $oldValues,   // ✅ array
            'new_values' => $newValues,   // ✅ array
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
}