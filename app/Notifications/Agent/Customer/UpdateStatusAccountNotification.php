<?php

namespace App\Notifications\Agent\Customer;

use App\Helper\CustomerHelper;
use App\Helper\LogHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdateStatusAccountNotification extends Notification
{
    use Queueable;

    private $customer;
    private $status;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $status
     */
    public function __construct($customer, $status)
    {
        //
        $this->customer = $customer;
        $this->status = $status;
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
                    ->subject("Mise à jour du status d'un client")
                    ->line('Le compte du client '.CustomerHelper::getName($this->customer)." à vue sont status passer à ".CustomerHelper::getStatusOpenAccount($this->status));
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
            "message" => 'Le compte du client '.CustomerHelper::getName($this->customer)." à vue sont status passer à ".CustomerHelper::getStatusOpenAccount($this->status)
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("Mise à jour du status d'un compte client")
            ->icon('/storage/log/notice.png')
            ->body('Le compte du client '.CustomerHelper::getName($this->customer)." à vue sont status passer à ".CustomerHelper::getStatusOpenAccount($this->status));
    }
}
