<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Authy\AuthyChannel;
use NotificationChannels\Authy\AuthyMessage;

class PhoneVerificationNotification extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    public $method;
    /**
     * @var bool
     */
    public $force;
    /**
     * @var null
     */
    public $action;
    /**
     * @var null
     */
    public $actionMessage;

    /**
     * Create a new notification instance.
     *
     * @param string $method
     * @param bool $force
     * @param null $action
     * @param null $actionMessage
     */
    public function __construct($method = 'sms', $force = false, $action = null, $actionMessage = null)
    {
        //
        $this->method = $method;
        $this->force = $force;
        $this->action = $action;
        $this->actionMessage = $actionMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [AuthyChannel::class];
    }

    /**
     * Build the Authy representation of the notification.
     *
     * @return \NotificationChannels\Authy\AuthyMessage
     */
    public function toAuthy()
    {
        $message = AuthyMessage::create()->method($this->method);

        if ($this->force) {
            $message->force();
        }

        if ($this->action) {
            $message->action($this->action);
        }

        if ($this->actionMessage) {
            $message->actionMessage($this->actionMessage);
        }

        return $message;
    }
}
