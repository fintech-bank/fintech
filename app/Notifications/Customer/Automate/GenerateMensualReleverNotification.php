<?php

namespace App\Notifications\Customer\Automate;

use App\Helper\CustomerHelper;
use App\Models\Customer\CustomerDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenerateMensualReleverNotification extends Notification
{
    use Queueable;

    public CustomerDocument $file;

    /**
     * Create a new notification instance.
     *
     * @param $file
     */
    public function __construct($file)
    {
        //
        $this->file = $file;
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
                    ->greeting("Bonjour ".CustomerHelper::getName($this->file->customer))
                    ->line("Votre relever du mois ".now()->monthName." est disponible sur votre espace");
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
            'icon' => 'fa-file-pdf',
            'color' => 'primary',
            'title' => 'Relevé Bancaire',
            'text' => 'Votre relevé bancaire de '.now()->monthName." est disponible",
            'time' => now()->shortAbsoluteDiffForHumans()
        ];
    }
}
