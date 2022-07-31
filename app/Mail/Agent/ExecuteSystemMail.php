<?php

namespace App\Mail\Agent;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExecuteSystemMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $command;

    protected $result;

    /**
     * Create a new message instance.
     *
     * @param $command
     * @param $result
     */
    public function __construct($command, $result)
    {
        //
        $this->command = $command;
        $this->result = $result;
    }

    /**
     * Build the message.
     *
     * @return $this|null
     */
    public function build()
    {
        if ($this->command == 'autoAcceptCreditPrlv') {
            $this->view('emails.agent.command.auto_accept_credit_prlv', [
                'resultat' => 'Nombre de prélèvement accepté: '.$this->result,
            ])->subject("Execution d'une commande automatique");
        }

        return null;
    }
}
