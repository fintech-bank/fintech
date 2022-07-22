<?php

namespace App\Notifications\Customer\Automate;

use App\Models\Customer\CustomerPret;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifRequestLoanOpenNotification extends Notification
{
    use Queueable;

    public $loan;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CustomerPret $loan)
    {
        //
        $this->loan = $loan;
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
            ->subject('Votre demande de pret bancaire')
            ->view('emails.customer.verif_request_loan', [
                "loan" => $this->loan
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
            'icon' => 'fa-euro-sign',
            'color' => 'primary',
            'title' => 'Votre demande de pret bancaire',
            'text' => 'Votre demande est maintenant en cours d\'étude',
            'time' => now()->shortAbsoluteDiffForHumans()
        ];
    }
}
