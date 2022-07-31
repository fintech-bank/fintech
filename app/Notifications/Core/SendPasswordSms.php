<?php

namespace App\Notifications\Core;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendPasswordSms extends Notification
{
    use Queueable;

    public Customer $customer;

    public string $password;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $password
     */
    public function __construct($customer, $password)
    {
        //
        $this->customer = $customer;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Votre mot de passe provisoire est le {$this->password}");
    }
}
