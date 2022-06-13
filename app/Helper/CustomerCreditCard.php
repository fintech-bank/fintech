<?php


namespace App\Helper;


use App\Models\Customer\CustomerDocument;
use App\Notifications\Agent\Customer\CreateCreditCardNotification;
use App\Notifications\Customer\SendCodeCardNotification;
use Plansky\CreditCard\Generator;

class CustomerCreditCard
{
    public static function dataDebitCard()
    {

    }

    public static function calcLimitPayment($amount)
    {
        $calc = round($amount * 1.9, -2);

        return $calc;
    }

    public static function calcLimitRetrait($amount)
    {
        $calc = round($amount / 1.9, -2);

        return $calc;
    }

    public static function isDiffered($type_debit)
    {
        return $type_debit != 'differed' ? false : true;
    }

    public static function getDebit($debit)
    {
        return $debit == 'DIFFERED' ? "Différé" : "Immédiat";
    }

    public static function getType($type)
    {
        switch ($type) {
            case 'physique':
                return 'Physique';
                break;

            case 'virtuel':
                return 'Virtuel';
                break;
        }
    }

    public static function getContact($contact)
    {
        return $contact == 1 ? "OUI" : "NON";
    }

    public static function getCreditCard($number, $obscure = true)
    {
        if ($obscure == true) {
            return "XXXX XXXX XXXX " . \Str::substr($number, 12, 16);
        } else {
            return $number;
        }
    }

    public static function getStatus($status, $labeled = true)
    {
        if($labeled == true) {
            switch ($status) {
                case 'active': return '<span class="badge badge-pill rounded badge-success">Active</span>'; break;
                case 'inactive': return '<span class="badge badge-pill rounded badge-danger">Inactive</span>'; break;
                default: return '<span class="badge badge-pill rounded badge-secondary">Annuler</span>'; break;
            }
        } else {
            switch ($status) {
                case 'active': return 'Active'; break;
                case 'inactive': return 'Inactive'; break;
                default: return 'Annuler'; break;
            }
        }
    }

    public static function createCard($customer, $wallet, $type = 'physique', $support = 'classic', $debit = 'immediate')
    {
        $card_generator = new Generator();
        $card = $wallet->cards()->create([
            'exp_month' => now()->month,
            'number' => $card_generator->single('40', 16),
            'type' => $type,
            'support' => $support,
            'debit' => $debit,
            'cvc' => rand(100,999),
            'code' => rand(1000,9999),
            'limit_retrait' => self::calcLimitRetrait($customer->income->pro_incoming),
            'limit_payment' => self::calcLimitPayment($customer->income->pro_incoming),
            'customer_wallet_id' => $wallet->id
        ]);

        // Génération des contrat
        $doc = DocumentFile::createDoc(
            $customer,
            'Convention CB Physique',
            3,
            null,
            true,
            true,
            false,
            true,
            $card
        );

        // Notification Code Carte Bleu
        $customer->info->notify(new SendCodeCardNotification($customer, $card->code, $card));

        auth()->user()->notify(new CreateCreditCardNotification($customer, $card, $doc));
        $customer->user->notify(new \App\Notifications\Customer\CreateCreditCardNotification($customer, $card, $doc));

        return $card;
    }
}
