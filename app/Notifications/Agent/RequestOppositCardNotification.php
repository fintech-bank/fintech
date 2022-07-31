<?php

namespace App\Notifications\Agent;

use App\Helper\CustomerHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestOppositCardNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public CustomerCreditCard $card;

    public string $type;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $card
     * @param $type
     */
    public function __construct($customer, $card, $type)
    {
        $this->customer = $customer;
        $this->card = $card;
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
        return ['mail'];
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
                    ->subject("Nouvelle demande d'opposition de carte bancaire")
                    ->line('Client: '.CustomerHelper::getName($this->customer))
                    ->line("Type d'opposition: ".$this->type)
                    ->line('Carte Bancaire :'.\App\Helper\CustomerCreditCard::getCreditCard($this->card->number, false));
    }
}
