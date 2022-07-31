<?php

namespace App\Services;

use Stripe\StripeClient;

class Stripe
{
    public $client;

    public function __construct()
    {
        $this->client = new StripeClient(config('services.stripe.api_secret'));
    }
}
