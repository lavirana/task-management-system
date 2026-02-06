<?php


use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if(!function_exists('logActivity')) {
    function logActivity($action, $task = Null, $oldValues=null, $newValues=null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'task_id' => $task?->id,
            'action' => $action,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(), 
        ]);
    }
}