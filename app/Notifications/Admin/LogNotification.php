<?php

namespace App\Notifications\Admin;

use App\Helper\LogHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LogNotification extends Notification
{
    use Queueable;

    public $type;

    public $message;

    /**
     * Create a new notification instance.
     *
     * @param $type
     * @param $message
     */
    public function __construct($type, $message)
    {
        //
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title(LogHelper::getTypeTitle($this->type))
            ->icon('/storage/log/'.$this->type.'.png')
            ->body($this->message);
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
            'type' => $this->type,
            'message' => $this->message,
        ];
    }
}
