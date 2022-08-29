<?php

namespace App\Notifications\Customer;

use App\Models\Core\Package;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdateTypeAccountNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public Package $type;

    public string $title = "Votre compte en ligne";

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param Package $type
     */
    public function __construct(Customer $customer,Package $type)
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
            ->subject($this->title)
            ->view('emails.customer.update_type_account', [
                'customer' => $this->customer,
                'type' => $this->type,
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
            'title' => $this->title,
            'text' => "Votre compte est passée à l'offre ".$this->type->name.' à '.eur($this->type->price),
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->icon('/storage/logo/logo_carre.png')
            ->body("Votre compte est passée à l'offre ".$this->type->name.' à '.eur($this->type->price));
    }
}
