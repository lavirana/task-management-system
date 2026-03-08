<?php

namespace App;

interface NotifierInterface {
    public function sendNotification($message);
}