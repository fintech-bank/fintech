<?php

namespace App\Notifications\Agent\Customer;

use App\Helper\CustomerHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdateTypeAccountNotification extends Notification
{
    use Queueable;

    public $customer;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $type
     */
    public function __construct($customer, $type)
    {
        //
        $this->customer = $customer;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', WebPushChannel::class];
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
                    ->subject('Mise à jour du type de compte client')
                    ->line("Le type de compte du client ".CustomerHelper::getName($this->customer)." est passer à ".$this->type->name);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "type" => "notice",
            "message" => "Le type de compte du client ".CustomerHelper::getName($this->customer)." est passer à ".$this->type->name
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("Mise à jour du type de compte d'un compte client")
            ->icon('/storage/log/notice.png')
            ->body("Le type de compte du client ".CustomerHelper::getName($this->customer)." est passer à ".$this->type->name);
    }
}
