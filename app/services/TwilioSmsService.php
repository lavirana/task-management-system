<?php

use App\SmsServiceInterface;

class TwilioSmsService implements SmsServiceInterface
{
    public function send($number, $message)
    {
        // Code to send SMS using Twilio API
        echo "Sending SMS to $number: $message via Twilio";
    }
}