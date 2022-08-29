<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerLoanHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreatePretNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public CustomerWallet $wallet;

    public CustomerDocument $document;

    public CustomerPret $pret;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerWallet $wallet
     * @param CustomerDocument $document
     * @param CustomerPret $pret
     */
    public function __construct(Customer $customer,CustomerWallet $wallet,CustomerDocument $document,CustomerPret $pret)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->document = $document;
        $this->pret = $pret;
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
            ->subject('Votre pret est disponible')
            ->view('emails.customer.create_loan', [
                'customer' => $this->customer,
                'wallet' => $this->wallet,
                'document' => $this->document,
                'pret' => $this->pret,
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
            'text' => "Votre Pret est maintenant disponible",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Votre Pret bancaire')
            ->icon('/storage/logo/logo_carre.png')
            ->body("Votre Pret est maintenant disponible");
    }
}
