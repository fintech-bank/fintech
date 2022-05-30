<?php

namespace App\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeContract extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $document;

    /**
     * Create a new message instance.
     *
     * @param $customer
     * @param $document
     */
    public function __construct($customer, $document)
    {
        //
        $this->customer = $customer;
        $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.customer.welcome_contract', [
            'customer' => $this->customer
        ])->subject("Bienvenue chez ".config('app.name'));
    }
}
