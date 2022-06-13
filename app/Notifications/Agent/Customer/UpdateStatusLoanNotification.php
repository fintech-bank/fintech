<?php

namespace App\Notifications\Agent\Customer;

use App\Helper\CustomerLoanHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdateStatusLoanNotification extends Notification
{
    use Queueable;

    public $customer;
    public $loan;
    public $status;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $loan
     * @param $status
     */
    public function __construct($customer, $loan, $status)
    {
        //
        $this->customer = $customer;
        $this->loan = $loan;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', WebPushChannel::class];
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
            ->subject("Mise à jour du status d'un pret bancaire")
            ->line("Le status du Pret Bancaire N°".$this->loan->reference." est passée à ".CustomerLoanHelper::getStatusLoan($this->status, false));
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
            "message" => "Le status du Pret Bancaire N°".$this->loan->reference." est passée à ".CustomerLoanHelper::getStatusLoan($this->status, false)
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("Mise à jour du status d'un pret bancaire")
            ->icon('/storage/log/notice.png')
            ->body("Le status du Pret Bancaire N°".$this->loan->reference." est passée à ".CustomerLoanHelper::getStatusLoan($this->status, false));
    }
}
