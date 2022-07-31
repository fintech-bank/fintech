<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateEpargneNotification extends Notification
{
    use Queueable;

    public $customer;

    public $wallet;

    public $document;

    public $epargne;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $wallet
     * @param $document
     * @param $epargne
     */
    public function __construct($customer, $wallet, $document, $epargne)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->document = $document;
        $this->epargne = $epargne;
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
            ->subject('Votre nouveau compte épargne est disponible')
            ->view('emails.customer.create_epargne', [
                'customer' => $this->customer,
                'wallet' => $this->wallet,
                'document' => $this->document,
                'epargne' => $this->epargne,
            ]);
    }
}
