<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateStatusAccountNotification extends Notification
{
    use Queueable;

    public $customer;
    public $status;
    /**
     * @var null
     */
    public $reason;
    /**
     * @var null
     */
    public $nameDocument;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $status
     * @param null $reason
     * @param null $nameDocument
     */
    public function __construct($customer, $status, $reason = null, $nameDocument = null)
    {
        //
        $this->customer = $customer;
        $this->status = $status;
        $this->reason = $reason;
        $this->nameDocument = $nameDocument;
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
        if($this->status == 'closed') {
            return (new MailMessage)
                ->subject("Votre compte en ligne")
                ->view('emails.customer.update_status_account', [
                    "customer" => $this->customer,
                    "statusLib" => CustomerHelper::getStatusOpenAccount($this->status),
                    "status" => $this->status,
                    "reason" => $this->reason
                ])->attach('/storage/gdd/'.$this->customer->id.'/courriers/');
        } else {
            return (new MailMessage)
                ->subject("Votre compte en ligne")
                ->view('emails.customer.update_status_account', [
                    "customer" => $this->customer,
                    "statusLib" => CustomerHelper::getStatusOpenAccount($this->status),
                    "status" => $this->status,
                    "reason" => $this->reason
                ]);
        }
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
            "message" => "Le status de votre compte est passée à: ".CustomerHelper::getStatusOpenAccount($this->status)
        ];
    }
}
