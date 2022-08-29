<?php

namespace App\Notifications\Agent\Customer;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReinitAuthCustomer extends Notification
{
    use Queueable;

    public Customer $customer;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        //
        $this->customer = $customer;
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
                    ->view('emails.customer.reinit_auth');
    }
}
