<?php

namespace App\Notifications\Agent\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ReinitCodeCustomer extends Notification
{
    use Queueable;

    public $code;

    /**
     * Create a new notification instance.
     *
     * @param $code
     */
    public function __construct($code)
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
        if (config('app.env') == 'local') {
            return ['mail'];
        } else {
            return [TwilioChannel::class];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("Votre code provisoire est le {$this->code}");
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Votre code provisoire est le {$this->code}");
    }
}
