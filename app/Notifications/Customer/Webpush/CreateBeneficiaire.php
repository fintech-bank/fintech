<?php

namespace App\Notifications\Customer\Webpush;

use App\Helper\CustomerHelper;
use App\Models\Customer\CustomerBeneficiaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreateBeneficiaire extends Notification
{
    use Queueable;

    public CustomerBeneficiaire $beneficiaire;

    /**
     * Create a new notification instance.
     *
     * @param CustomerBeneficiaire $beneficiaire
     */
    public function __construct(CustomerBeneficiaire $beneficiaire)
    {
        //
        $this->beneficiaire = $beneficiaire;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Nouveau bénéficiaire')
            ->icon('/storage/logo/logo_carre.png')
            ->body('Un nouveau bénéficiaire à été ajouté à votre compte');
    }
}
