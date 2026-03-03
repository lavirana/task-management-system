<?php

namespace App;

interface SmsServiceInterface
{
    public function send($number, $message);
}
