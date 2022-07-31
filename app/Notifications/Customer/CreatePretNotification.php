<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreatePretNotification extends Notification
{
    use Queueable;

    public $customer;

    public $wallet;

    public $document;

    public $pret;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $wallet
     * @param $document
     * @param $pret
     */
    public function __construct($customer, $wallet, $document, $pret)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->document = $document;
        $this->pret = $pret;
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
            ->subject('Votre pret est disponible')
            ->view('emails.customer.create_loan', [
                'customer' => $this->customer,
                'wallet' => $this->wallet,
                'document' => $this->document,
                'pret' => $this->pret,
            ]);
    }
}
