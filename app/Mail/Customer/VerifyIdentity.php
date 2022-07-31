<?php

namespace App\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyIdentity extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    public $verify_uri;

    /**
     * Create a new message instance.
     *
     * @param $customer
     * @param $verify_uri
     */
    public function __construct($customer, $verify_uri)
    {
        //
        $this->customer = $customer;
        $this->verify_uri = $verify_uri;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.customer.verify_identity', [
            'customer' => $this->customer,
            'verify_uri' => $this->verify_uri,
        ])
            ->subject("Vérification d'identité");
    }
}
