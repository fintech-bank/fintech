<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerTransferHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InitTransferController extends Notification
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
            ->subject("Votre virement bancaire")
            ->view("emails.customer.init_transfer", [
                "customer" => $this->transfer->wallet->customer,
                "transfer" => $this->transfer
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
            "type" => "notice",
            "message" => "Un virement de ".eur($this->transfer->amount)." à été initié pour ".CustomerTransferHelper::getNameBeneficiaire($this->transfer->beneficiaire)
        ];
    }
}
