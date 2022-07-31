<?php

namespace App\Notifications\Agent\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerWalletHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreatePretNotification extends Notification
{
    use Queueable;

    public $customer;

    public $wallet;

    public $document;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $wallet
     * @param $document
     */
    public function __construct($customer, $wallet, $document)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->document = $document;
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
            ->subject('Nouveau compte bancaire pour un client')
            ->line('Un nouveau compte bancaire à été créer pour le client :'.CustomerHelper::getName($this->customer))
            ->line('Compte N°'.$this->wallet->number_account)
            ->line('Type: '.CustomerWalletHelper::getTypeWallet($this->wallet->type));
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
            'type' => 'notice',
            'message' => 'Un nouveau compte bancaire à été créer pour le client :'.CustomerHelper::getName($this->customer),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Nouveau compte bancaire pour un client')
            ->icon('/storage/log/notice.png')
            ->body('Un nouveau compte bancaire à été créer pour le client :'.CustomerHelper::getName($this->customer));
    }
}
