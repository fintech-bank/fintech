<?php

namespace App\Notifications\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWithdraw;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateWithdrawNotification extends Notification
{
    use Queueable;

    public Customer $customer;
    public CustomerWithdraw $withdraw;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerWithdraw $withdraw
     */
    public function __construct(Customer $customer, CustomerWithdraw $withdraw)
    {
        //
        $this->customer = $customer;
        $this->withdraw = $withdraw;
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
            ->subject("Nouvelle demande de retrait bancaire")
            ->view('emails.customer.create_withdraw', [
                'customer' => $this->customer,
                'withdraw' => $this->withdraw
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
            'icon' => 'fa-money-bill-transfer',
            'color' => 'primary',
            'title' => 'Retrait bancaire',
            'text' => "Votre demande de retrait bancaire est disponible",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Retrait bancaire')
            ->icon('/storage/logo/logo_carre.png')
            ->body("Votre demande de retrait bancaire est disponible");
    }

}
