<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerHelper;
use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdateStatusAccountNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public string $status;

    /**
     * @var string|null
     */
    public ?string $reason;

    /**
     * @var string|null
     */
    public ?string $nameDocument;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param string $status
     * @param string|null $reason
     * @param string|null $nameDocument
     */
    public function __construct(Customer $customer, string $status,string $reason = null,string $nameDocument = null)
    {
        //
        $this->customer = $customer;
        $this->status = $status;
        $this->reason = $reason;
        $this->nameDocument = $nameDocument;
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
        if ($this->status == 'closed') {
            return (new MailMessage)
                ->subject('Votre compte en ligne')
                ->view('emails.customer.update_status_account', [
                    'customer' => $this->customer,
                    'statusLib' => CustomerHelper::getStatusOpenAccount($this->status),
                    'status' => $this->status,
                    'reason' => $this->reason,
                ])->attach('/storage/gdd/'.$this->customer->id.'/courriers/');
        } else {
            return (new MailMessage)
                ->subject('Votre compte en ligne')
                ->view('emails.customer.update_status_account', [
                    'customer' => $this->customer,
                    'statusLib' => CustomerHelper::getStatusOpenAccount($this->status),
                    'status' => $this->status,
                    'reason' => $this->reason,
                ]);
        }
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
            'icon' => 'fa-euro-sign',
            'color' => 'primary',
            'title' => 'Votre compte bancaire',
            'text' => 'Le status de votre compte est passée à: '.CustomerHelper::getStatusOpenAccount($this->status),
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Votre compte bancaire')
            ->icon('/storage/logo/logo_carre.png')
            ->body('Le status de votre compte est passée à: '.CustomerHelper::getStatusOpenAccount($this->status));
    }
}
