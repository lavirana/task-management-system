<?php

namespace App;

interface PaymentGatewayInterface
{
    public function pay($amount);
}
