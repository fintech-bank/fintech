<?php

namespace App\Notifications\Core;

use App\Helper\CustomerHelper;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\OvhSmsChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\OvhSmsMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class SendPasswordSms extends Notification
{
    use Queueable;

    public string $password;
    public Customer $customer;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param string $password
     */
    public function __construct(Customer $customer, string $password)
    {
        //
        $this->password = $password;
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (config('app.env') == 'local') {
            return [WebPushChannel::class, 'mail'];
        } else {
            return [OvhSmsChannel::class, WebPushChannel::class];
        }
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(config('app.name').' - Votre mot de passe')
            ->greeting('Bonjour '.CustomerHelper::getName($this->customer, true))
            ->line("Votre mot de passe provisoire est le {$this->password}");
    }

    public function toOvhSms($notifiable)
    {
        return (new OvhSmsMessage("Votre mot de passe provisoire est le {$this->password}"));
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Votre mot de passe')
            ->icon('/storage/logo/logo_carre.png')
            ->body("Votre mot de passe provisioire est le {$this->password}");
    }
}
