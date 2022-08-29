<?php

namespace App\Notifications\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateWalletNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public CustomerWallet $wallet;

    public CustomerDocument $document;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerWallet $wallet
     * @param CustomerDocument $document
     */
    public function __construct(Customer $customer, CustomerWallet $wallet, CustomerDocument $document)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->document = $document;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', WebPushChannel::class];
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
                    ->subject('Votre nouveau compte bancaire est disponible')
                    ->view('emails.customer.create_wallet', [
                        'customer' => $this->customer,
                        'wallet' => $this->wallet,
                        'document' => $this->document,
                    ]);
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Votre nouveau compte bancaire est disponible')
            ->icon('/storage/logo/logo_carre.png')
            ->body('Votre nouveau compte bancaire est maintenant actif');
    }
}
