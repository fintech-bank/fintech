<?php

namespace App\Services\Stripe\Facade;

class StripeIdentityFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'identity';
    }
}
