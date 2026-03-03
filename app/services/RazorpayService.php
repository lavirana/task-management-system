<?php

namespace App\Services;

class RazorpayService implements PaymentGatewayInterface {

    public function pay($amount){
        return "Paid $amount using razorpay";
    }

}
