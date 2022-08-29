<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerLoanHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateCreditCardNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public CustomerCreditCard $card;

    public CustomerDocument $document;

    public string $title = "Votre nouvelle carte bancaire";

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerCreditCard $card
     * @param CustomerDocument $document
     */
    public function __construct(Customer $customer, CustomerCreditCard $card, CustomerDocument $document)
    {
        //
        $this->customer = $customer;
        $this->card = $card;
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
                    ->subject($this->title)
                    ->view('emails.customer.create_credit_card', [
                        'card' => $this->card,
                        'document' => $this->document,
                        'customer' => $this->customer,
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
            'icon' => 'fa-creditcard',
            'color' => 'primary',
            'title' => $this->title,
            'text' => 'Une nouvelle carte bancaire à été créer',
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->icon('/storage/logo/logo_carre.png')
            ->body('Une nouvelle carte bancaire à été créer');
    }
}
