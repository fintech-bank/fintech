<?php

namespace App\Services;

use GuzzleHttp\Client;

class Ovh extends \Ovh\Api
{
    public function __construct(Client $http_client = null)
    {
        parent::__construct(config('ovh.app_key'), config('ovh.app_secret'), config('ovh.endpoint'), config('ovh.consumer_key'), $http_client);
    }

    public function services()
    {
        return $this->get('/sms/');
    }

    public function send($message, $phone)
    {
        return $this->post('/sms/'.config('ovh.sms_service').'/jobs', [
            "charset" => 'UTF-8',
            "class"=> "phoneDisplay",
            "coding"=> "7bit",
            "message"=> $message,
            "noStopClause"=> false,
            "priority"=> "high",
            "receivers"=> [ $phone ],
            "senderForResponse"=> true,
            "validityPeriod"=> 2880
        ]);
    }
}
