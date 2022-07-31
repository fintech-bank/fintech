<?php

namespace App\Notifications\Customer\Automate;

use App\Models\Customer\CustomerPret;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptedLoanChargeNotification extends Notification
{
    use Queueable;

    public CustomerPret $loan;

    /**
     * Create a new notification instance.
     *
     * @param  CustomerPret  $loan
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
            ->subject('Votre pret bancaire N°'.$this->loan->reference)
            ->view('emails.customer.accepted_loan_charge', [
                'loan' => $this->loan,
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
            'title' => 'Votre pret bancaire n°'.$this->loan->reference,
            'text' => 'Le montant de votre pret est maintenant disponible',
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
