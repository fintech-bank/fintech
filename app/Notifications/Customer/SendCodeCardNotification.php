<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendCodeCardNotification extends Notification
{
    use Queueable;

    public $customer;
    public $code;
    private $card;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $code
     * @param $card
     */
    public function __construct($customer, $code, $card)
    {
        //
        $this->customer = $customer;
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
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Votre code de la carte bancaire ".$this->card->number." est le ".base64_decode($this->code));
    }
}
