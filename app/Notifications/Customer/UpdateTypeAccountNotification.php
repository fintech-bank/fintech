<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerLoanHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateTypeAccountNotification extends Notification
{
    use Queueable;

    public $customer;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $type
     */
    public function __construct($customer, $type)
    {
        //
        $this->customer = $customer;
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
        return ['mail', 'database'];
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
            ->subject("Votre compte en ligne")
            ->view('emails.customer.update_type_account', [
                "customer" => $this->customer,
                "type" => $this->type
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
            'icon' => 'fa-box',
            'color' => 'primary',
            'title' => 'Votre compte en ligne',
            'text' => "Votre compte est passée à l'offre ".$this->type->name." à " .eur($this->type->price),
            'time' => now()->shortAbsoluteDiffForHumans()
        ];
    }
}
