<?php

namespace App\Notifications\Agent\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ReinitCodeCustomer extends Notification
{
    use Queueable;

    public string $code;

    /**
     * Create a new notification instance.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        //
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }


    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Code SECURPASS')
            ->icon('/storage/logo/logo_carre.png')
            ->body("Votre code provisoire est le {$this->code}");
    }
}
