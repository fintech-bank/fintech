<?php

namespace App\Notifications\Customer\Automate;

use App\Models\Customer\CustomerSepa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPrlvPresented extends Notification
{
    use Queueable;

    private CustomerSepa $sepa;

    /**
     * Create a new notification instance.
     *
     * @param  CustomerSepa  $sepa
     */
    public function __construct(CustomerSepa $sepa)
    {
        $this->sepa = $sepa;
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
            ->subject('Nouveau prélèvement bancaire')
            ->view('emails.customer.new_prlv_presented', [
                'sepa' => $this->sepa,
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
            'title' => 'Prélèvement Bancaire',
            'text' => 'Un nouveau prélèvement bancaire est actuellement présenté',
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
