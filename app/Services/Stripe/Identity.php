<?php

namespace App\Services\Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\Identity\VerificationSession;

class Identity extends \App\Services\Stripe
{
    /**
     * @param array $metadata
     * @return VerificationSession
     * @throws ApiErrorException
     */
    public function createIdentitySession(array $metadata)
    {
        return $this->client->identity->verificationSessions->create([
            'type' => 'document',
            'metadata' => $metadata
        ]);
    }
}
