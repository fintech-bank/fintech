<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendCodeToSignSMSNotification extends Notification
{
    use Queueable;

    public $file;
    public $code;

    /**
     * Create a new notification instance.
     *
     * @param $file
     * @param $code
     */
    public function __construct($file, $code)
    {
        //
        $this->file = $file;
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
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content('Voici votre code pour signer le document "'.$this->file->name.'": '.$this->code);
    }
}
