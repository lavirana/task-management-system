<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index($user_id){
        $query = Notification::with('notifiableUser'); 
        $notifications = $query->latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }
}
