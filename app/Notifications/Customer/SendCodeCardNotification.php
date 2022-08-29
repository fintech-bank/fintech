<?php

namespace App\Notifications\Customer;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\OvhSmsChannel;
use Illuminate\Notifications\Messages\OvhSmsMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class SendCodeCardNotification extends Notification
{
    use Queueable;

    public string $code;

    public CustomerCreditCard $card;

    /**
     * Create a new notification instance.
     *
     * @param string $code
     * @param CustomerCreditCard $card
     */
    public function __construct(string $code, CustomerCreditCard $card)
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
        return [OvhSmsChannel::class, WebPushChannel::class];
    }

    public function toOvhSms($notifiable)
    {
        return (new OvhSmsMessage('Votre code de la carte bancaire '.$this->card->number.' est le '.base64_decode($this->code)));
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Code de carte bancaire')
            ->icon('/storage/logo/logo_carre.png')
            ->body('Votre code de la carte bancaire '.$this->card->number.' est le '.base64_decode($this->code));
    }
}
