<?php

namespace App\Services;
use App\NotifierInterface;

class DatabaseNotifier implements NotifierInterface {
    public function send($message) {
        // Simulate saving the notification to the database
        return "Database notification saved: " . $message;
    }
}