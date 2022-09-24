<?php

namespace App\Notifications\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCheckDeposit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateValidDepositCheckNotification extends Notification
{
    use Queueable;

    public Customer $customer;
    public CustomerCheckDeposit $deposit;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerCheckDeposit $deposit
     */
    public function __construct(Customer $customer, CustomerCheckDeposit $deposit)
    {
        //
        $this->customer = $customer;
        $this->deposit = $deposit;
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
            ->subject("Votre demande de remise bancaire")
            ->view('emails.customer.valid_deposit_check', [
                'customer' => $this->customer,
                'deposit' => $this->deposit
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
            'icon' => 'fa-money-check',
            'color' => 'primary',
            'title' => "Votre demande de remise bancaire",
            'text' => 'Votre remise N°'.$this->deposit->reference." à été validé",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Remise Bancaire')
            ->icon('/storage/logo/logo_carre.png')
            ->body('Votre remise N°'.$this->deposit->reference." à été validé");
    }
}
