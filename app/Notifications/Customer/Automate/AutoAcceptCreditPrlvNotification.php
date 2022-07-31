<?php

namespace App\Notifications\Customer\Automate;

use App\Helper\CustomerSepaHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AutoAcceptCreditPrlvNotification extends Notification
{
    use Queueable;

    public $customer;

    public $prlv;

    public $status;

    /**
     * Create a new notification instance.
     *
     * @param $customer
     * @param $prlv
     * @param $status
     */
    public function __construct($customer, $prlv, $status)
    {
        //
        $this->customer = $customer;
        $this->prlv = $prlv;
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
        return ['mail', 'database'];
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
                    ->subject('Votre Prélèvement Bancaire')
                    ->view('emails.customer.auto_accept_prlv', [
                        'customer' => $this->customer,
                        'prlv' => $this->prlv,
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
        switch ($this->status) {
            case 'waiting':
                $icon = 'fa-spinner fa-spin-pulse';
                $color = 'info';
                break;

            case 'processed':
                $icon = 'fa-check';
                $color = 'success';
                break;

            case 'rejected':
                $icon = 'fa-arrow-right-arrow-left';
                $color = 'danger';
                break;

            case 'return':
                $icon = 'fa-arrow-right-arrow-left';
                $color = 'info';
                break;

            case 'refunded':
                $icon = 'fa-arrow-right-arrow-left';
                $color = 'primary';
                break;

            default:
                $icon = 'fa-triangle-exclamation';
                $color = 'primary';
                break;
        }

        $title = 'Prélèvement bancaire';
        $text = 'Le status du prélèvement bancaire '.$this->prlv->number_mandate.' est passée à '.CustomerSepaHelper::getStatus($this->status, false);
        $time = now()->shortAbsoluteDiffForHumans();

        return [
            'icon' => $icon,
            'color' => $color,
            'title' => $title,
            'text' => $text,
            'time' => $time,
        ];
    }
}
