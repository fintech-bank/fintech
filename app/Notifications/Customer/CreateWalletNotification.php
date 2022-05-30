<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateWalletNotification extends Notification
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
                    ->subject("Votre nouveau compte bancaire est disponible")
                    ->view("emails.customer.create_wallet", [
                        "customer" => $this->customer,
                        "wallet" => $this->wallet,
                        "document" => $this->document
                    ]);
    }

}
