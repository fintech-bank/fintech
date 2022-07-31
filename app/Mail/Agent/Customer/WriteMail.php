<?php

namespace App\Mail\Agent\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WriteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    public $message;

    /**
     * Create a new message instance.
     *
     * @param $customer
     * @param $message
     */
    public function __construct($customer, $message)
    {
        //
        $this->customer = $customer;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.customer.write_mail', [
            'content' => $this->message,
        ])
            ->subject('Nouveau message de la part de votre conseiller')
            ->from(auth()->user()->email, auth()->user()->name);
    }
}
