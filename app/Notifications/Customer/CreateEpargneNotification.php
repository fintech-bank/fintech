<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerLoanHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateEpargneNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public CustomerWallet $wallet;

    public CustomerDocument $document;

    public CustomerEpargne $epargne;

    public string $title = "Votre nouveau compte épargne est disponible";

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerWallet $wallet
     * @param CustomerDocument $document
     * @param CustomerEpargne $epargne
     */
    public function __construct(Customer $customer, CustomerWallet $wallet, CustomerDocument $document, CustomerEpargne $epargne)
    {
        //
        $this->customer = $customer;
        $this->wallet = $wallet;
        $this->document = $document;
        $this->epargne = $epargne;
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
            ->view('emails.customer.create_epargne', [
                'customer' => $this->customer,
                'wallet' => $this->wallet,
                'document' => $this->document,
                'epargne' => $this->epargne,
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
            'title' => $this->title,
            'text' => "Votre nouveau compte épargne est maintenant actif",
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    /**
     * @param mixed $notifiable
     * @param $notification
     * @return WebPushMessage
     */
    public function toWebPush(mixed $notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->icon('/storage/logo/logo_carre.png')
            ->body('Votre nouveau compte épargne est maintenant actif');
    }
}
