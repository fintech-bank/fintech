<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
                    ->subject("Votre nouvelle carte bancaire")
                    ->view('emails.customer.create_credit_card', [
                        "card" => $this->card,
                        "document" => $this->document,
                        "customer" => $this->customer
                    ]);
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
            //
        ];
    }
}
