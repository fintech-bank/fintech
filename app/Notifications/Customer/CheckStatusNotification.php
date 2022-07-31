<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerCheckHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckStatusNotification extends Notification
{
    use Queueable;

    public $customer;

    public $check;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $check
     */
    public function __construct($customer, $check)
    {
        //
        $this->customer = $customer;
        $this->check = $check;
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
                    ->subject('Votre commande de chéquier')
            ->view('emails.customer.status_check', [
                'customer' => $this->customer,
                'check' => $this->check,
                'check_status' => CustomerCheckHelper::getStatus($this->check->status),
            ]);
    }
}
