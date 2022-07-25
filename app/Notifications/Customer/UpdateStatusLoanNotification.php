<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerHelper;
use App\Helper\CustomerLoanHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
            ->subject("Votre Pret bancaire N°".$this->loan->reference)
            ->view('emails.customer.status_loan', [
                'customer' => $this->customer,
                'loan' => $this->loan,
                'status' => $this->status
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
            'icon' => 'fa-certificate',
            'color' => 'primary',
            'title' => 'Votre pret bancaire',
            'text' => "Le status de votre pret bancaire N°".$this->loan->reference." est passée à: ".CustomerLoanHelper::getStatusLoan($this->status),
            'time' => now()->shortAbsoluteDiffForHumans()
        ];
    }
}
