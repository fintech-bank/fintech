<?php

namespace App\Notifications\Customer\Automate;

use App\Helper\CustomerTransferHelper;
use App\Models\Customer\CustomerTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateStatusVirementNotification extends Notification
{
    use Queueable;

    private CustomerTransfer $virement;
    private string $status;

    /**
     * Create a new notification instance.
     *
     * @param $virement
     * @param $status
     */
    public function __construct($virement, $status)
    {
        $this->virement = $virement;
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
            ->subject('Votre virement bancaire')
            ->view('emails.customer.update_status_virement', [
                "virement" => $this->virement,
                "status" => CustomerTransferHelper::getStatusTransfer($this->status)
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
            'title' => 'Virement Bancaire',
            'text' => "L'état de votre virement N°".$this->virement->reference." à été mise à jours",
            'time' => now()->shortAbsoluteDiffForHumans()
        ];
    }
}
