<?php

namespace App\Notifications\Customer\Automate;

use App\Models\Customer\CustomerMobility;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GetMobilityBankEndNotification extends Notification
{
    use Queueable;

    public CustomerMobility $mobility;

    /**
     * Create a new notification instance.
     *
     * @param CustomerMobility $mobility
     */
    public function __construct(CustomerMobility $mobility)
    {
        //
        $this->mobility = $mobility;
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
            ->subject("Votre demande de mobilité bancaire")
            ->view('emails.customer.mobility_bank_end', [
                'mobility' => $this->mobility
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
            'icon' => 'fa-arrow-right-arrow-left',
            'color' => 'primary',
            'title' => 'Votre demande de mobilité bancaire',
            'text' => 'Le status de votre demande à évolué',
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }
}
