<?php

namespace App\Services;
use App\Interfaces\NotifierInterface;

class DatabaseNotifier implements NotifierInterface {
    public function send(string $message) {
        // Simulate saving the notification to the database
        return "Database notification saved: " . $message;
    }
}