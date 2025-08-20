<?php

namespace App\Services;
use Razorpay\Api\Api;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $RAZORPAY_KEY_ID = env('RAZORPAY_KEY');
        $RAZORPAY_KEY_SECRET = env('RAZORPAY_SECRET');

        $this->api = new Api($RAZORPAY_KEY_ID, $RAZORPAY_KEY_SECRET);
    }

    public function createOrder($amount, $receipt = 'order_receipt')
    {
        return $this->api->order->create([
            'amount' => (int)$amount,
            'currency' => "INR",
            'receipt' => $receipt,
            'payment_capture' => 1,
        ]);
    }

    public function verifySignature($attributes)
    {
        return $this->api->utility->verifyPaymentSignature($attributes);
    }
}
