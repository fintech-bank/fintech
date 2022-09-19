<?php

namespace App\Http\Controllers;

use App\Helper\LogHelper;
use App\Models\Customer\CustomerInfo;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends CashierController
{
    /**
     * Handle customer subscription updated.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        $customer = $payload['data']['object']['customer'];

        // handle the incoming event...

        return new Response('Webhook Handled', 200);
    }

    protected function handleIdentityVerificationSessionVerified(array $payload)
    {
        $result = $payload['data']['object'];

        if ($payload['data']['object']['status'] == 'verified') {
            CustomerInfo::where('customer_id', $payload['data']['object']['metadata']['customer_id'])->first()->verified();
        }

        LogHelper::notify('info', "Les informations d'un utilisateur ont été vérifié");

        return $result;
    }

    protected function handlePaymentIntentCreated(array $payload)
    {
        $result = $payload['data']['object'];
    }
}
