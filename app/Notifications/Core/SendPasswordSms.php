<?php

namespace App\Notifications\Core;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\OvhSmsChannel;
use Illuminate\Notifications\Messages\OvhSmsMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendPasswordSms extends Notification
{
    use Queueable;

    public string $password;

    /**
     * Create a new notification instance.
     *
     * @param $password
     */
    public function __construct($password)
    {
        //
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
        return [OvhSmsChannel::class];
    }

    public function toOvhSms($notifiable)
    {
        return (new OvhSmsMessage("Votre mot de passe provisoire est le {$this->password}"));
    }
}
