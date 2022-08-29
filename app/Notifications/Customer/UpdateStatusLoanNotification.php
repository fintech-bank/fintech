<?php

namespace App\Notifications\Customer;

use App\Helper\CustomerLoanHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpdateStatusLoanNotification extends Notification
{
    use Queueable;

    public Customer $customer;

    public CustomerPret $loan;

    public string $status;

    /**
     * Create a new notification instance.
     *
     * @param Customer $customer
     * @param CustomerPret $loan
     * @param string $status
     */
    public function __construct(Customer $customer, CustomerPret $loan, string $status)
    {
        //
        $this->customer = $customer;
        $this->loan = $loan;
        $this->status = $status;
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
            ->subject('Votre Pret bancaire N°'.$this->loan->reference)
            ->view('emails.customer.status_loan', [
                'customer' => $this->customer,
                'loan' => $this->loan,
                'status' => $this->status,
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
            'text' => 'Le status de votre pret bancaire N°'.$this->loan->reference.' est passée à: '.CustomerLoanHelper::getStatusLoan($this->status),
            'time' => now()->shortAbsoluteDiffForHumans(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Votre Pret bancaire')
            ->icon('/storage/logo/logo_carre.png')
            ->body('Le status de votre pret bancaire N°'.$this->loan->reference.' est passée à: '.CustomerLoanHelper::getStatusLoan($this->status, false));
    }
}
