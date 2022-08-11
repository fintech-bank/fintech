<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\OvhSmsChannel;
use Illuminate\Notifications\Messages\OvhSmsMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendCodeCardNotification extends Notification
{
    use Queueable;

    public $code;

    private $card;

    /**
     * Create a new notification instance.
     *
     * @param $code
     * @param $card
     */
    public function __construct($code, $card)
    {
        $this->code = $code;
        $this->card = $card;
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
        return (new OvhSmsMessage('Votre code de la carte bancaire '.$this->card->number.' est le '.base64_decode($this->code)));
    }
}
