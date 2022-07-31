<?php

namespace App\Notifications\Agent\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerTransferHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class InitTransferNotification extends Notification
{
    use Queueable;

    private $transfer;

    /**
     * Create a new notification instance.
     *
     * @param $transfer
     */
    public function __construct($transfer)
    {
        //
        $this->transfer = $transfer;
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
            ->subject("Initialisation d'un virement Bancaire")
            ->line('Le client '.CustomerHelper::getName($this->transfer->wallet->customer).' à initié un virement bancaire')
            ->line('Virement de '.eur($this->transfer->amount).' vers '.CustomerTransferHelper::getNameBeneficiaire($this->transfer->beneficiaire));
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
            'message' => 'Le client '.CustomerHelper::getName($this->transfer->wallet->customer).' à initié un virement bancaire',
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("Initialisation d'un virement Bancaire")
            ->icon('/storage/log/notice.png')
            ->body('Virement de '.eur($this->transfer->amount).' vers '.CustomerTransferHelper::getNameBeneficiaire($this->transfer->beneficiaire));
    }
}
