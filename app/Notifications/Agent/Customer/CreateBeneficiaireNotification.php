<?php

namespace App\Notifications\Agent\Customer;

use App\Helper\CustomerHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateBeneficiaireNotification extends Notification
{
    use Queueable;

    public $customer;
    public $beneficiaire;
    public $wallet;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $beneficiaire
     * @param $wallet
     */
    public function __construct($customer, $beneficiaire, $wallet)
    {
        //
        $this->customer = $customer;
        $this->beneficiaire = $beneficiaire;
        $this->wallet = $wallet;
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
            ->subject('Nouveau bénéficiaire pour le client: '.CustomerHelper::getName($this->customer))
            ->view('emails.agent.transfers.add_beneficiaire', [
                'customer' => $this->customer,
                'beneficiaire' => $this->beneficiaire,
                'wallet' => $this->wallet
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
            "type" => "notice",
            "message" => 'Un nouveau bénéficiaire à été ajouté pour le client :'.CustomerHelper::getName($this->customer)
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("Nouveau bénéficiaire pour un client")
            ->icon('/storage/log/notice.png')
            ->body('Un nouveau bnéficiaire à été créer pour le client :'.CustomerHelper::getName($this->customer));
    }
}
