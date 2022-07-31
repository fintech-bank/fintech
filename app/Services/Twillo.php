<?php

namespace App\Services;

use Twilio\Rest\Client;

class Twillo
{
    public $client;

    public function __construct()
    {
        $this->client = new Client(
            config('twilio-notification-channel.account_sid'),
            config('twilio-notification-channel.auth_token')
        );
    }
}
