<?php

namespace App\Services;

use Exception;

class PaymentService{

    protected $gateway;

    public function __construct(string $gateway = 'stripe')
    {
        $this->gateway = $gateway;
    }
    public function charge($amount, $currency = 'USD')
    {
        try {
            // Here you would implement the logic to charge the user using the selected gateway
            // For example, if using Stripe:
            if($amount <= 0){
                throw new Exception('Invalid payment amount');
            }
            if ($this->gateway === 'stripe') {
                // Stripe charge logic
                return "Charged {$amount} {$currency} via Stripe.";
            } elseif ($this->gateway === 'paypal') {
                // PayPal charge logic
                return "Charged {$amount} {$currency} via PayPal.";
            } else {
                throw new Exception("Unsupported payment gateway: {$this->gateway}");
            }
        } catch (Exception $e) {
            // Handle exceptions, log errors, etc.
            return "Error charging payment: " . $e->getMessage();
        }
    }

}
