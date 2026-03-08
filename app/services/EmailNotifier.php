<?php

namespace App\Services;
use App\Interfaces\NotifierInterface;

class EmailNotifier implements NotifierInterface {
    public function send(string $message) {
        return "Email notification sent: " . $message;
    }
}