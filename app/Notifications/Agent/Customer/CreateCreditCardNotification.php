<?php

namespace App\Notifications\Agent\Customer;

use App\Helper\CustomerCreditCard;
use App\Helper\CustomerHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateCreditCardNotification extends Notification
{
    use Queueable;

    public $customer;
    public $card;
    public $document;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $card
     * @param $document
     */
    public function __construct($customer, $card, $document)
    {
        //
        $this->customer = $customer;
        $this->card = $card;
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
            ->subject("Création d'une nouvelle carte bancaire")
            ->line('Une nouvelle Carte bancaire à été créer pour le client :'.CustomerHelper::getName($this->customer))
            ->line('Numéro'.CustomerCreditCard::getCreditCard($this->card->number, true))
            ->line('Type: '.CustomerCreditCard::getType($this->card->type))
            ->line('Support: '.\Str::ucfirst($this->card->support))
            ->line('Type de débit: '.CustomerCreditCard::getDebit($this->card->debit));
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
            "message" => 'Une nouvelle Carte bancaire à été créer pour le client :'.CustomerHelper::getName($this->customer)
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("Création d'une nouvelle carte bancaire")
            ->icon('/storage/log/notice.png')
            ->body('Une nouvelle Carte bancaire à été créer pour le client :'.CustomerHelper::getName($this->customer));
    }
}
