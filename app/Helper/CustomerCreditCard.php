<?php

namespace App\Helper;

use App\Notifications\Agent\Customer\CreateCreditCardNotification;
use App\Notifications\Customer\SendCodeCardNotification;
use Plansky\CreditCard\Generator;

class CustomerCreditCard
{
    public static function calcLimitPayment($amount): float
    {
        $calc = round($amount * 1.9, -2);

        return $calc;
    }

    public static function calcLimitRetrait($amount): float
    {
        $calc = round($amount / 1.9, -2);

        return $calc;
    }

    public static function isDiffered($type_debit): bool
    {
        return $type_debit != 'differed' ? false : true;
    }

    public static function getDebit($debit): string
    {
        return $debit == 'differed' ? 'Différé' : 'Immédiat';
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

    public static function getContact($contact): string
    {
        return $contact == 1 ? 'OUI' : 'NON';
    }

    public static function getCreditCard($number, $obscure = true)
    {
        if ($obscure == true) {
            return 'XXXX XXXX XXXX '.\Str::substr($number, 12, 16);
        } else {
            return $number;
        }
    }

    public static function getStatus($status, $labeled = true): string
    {
        if ($labeled == true) {
            switch ($status) {
                case 'active':
                    return '<span class="badge badge-pill rounded badge-success">Active</span>';
                    break;
                case 'inactive':
                    return '<span class="badge badge-pill rounded badge-danger">Inactive</span>';
                    break;
                default:
                    return '<span class="badge badge-pill rounded badge-secondary">Annuler</span>';
                    break;
            }
        } else {
            switch ($status) {
                case 'active':
                    return 'Active';
                    break;
                case 'inactive':
                    return 'Inactive';
                    break;
                default:
                    return 'Annuler';
                    break;
            }
        }
    }

    public static function createCard($customer, $wallet, $type = 'physique', $support = 'classic', $debit = 'immediate', $limit_payment = 0)
    {
        $card_generator = new Generator();
        if ($type == 'physique') {
            $card = $wallet->cards()->create([
                'exp_month' => now()->month,
                'number' => $card_generator->single('40', 16),
                'type' => $type,
                'support' => $support,
                'debit' => $debit,
                'cvc' => rand(100, 999),
                'code' => base64_encode(rand(1000, 9999)),
                'limit_retrait' => self::calcLimitRetrait($customer->income->pro_incoming),
                'limit_payment' => self::calcLimitPayment($customer->income->pro_incoming),
                'customer_wallet_id' => $wallet->id,
            ]);

            // Génération des contrat
            $doc = DocumentFile::createDoc(
                $customer,
                'Convention CB Physique',
                null,
                3,
                null,
                true,
                true,
                false,
                true,
                ['card' => $card]
            );

            // Notification Code Carte Bleu
            $customer->info->notify(new SendCodeCardNotification($customer, base64_decode($card->code), $card));

            auth()->user()->notify(new CreateCreditCardNotification($customer, $card, $doc));
            $customer->user->notify(new \App\Notifications\Customer\CreateCreditCardNotification($customer, $card, $doc));
        } else {
            $card = $wallet->cards()->create([
                'exp_month' => now()->month,
                'number' => $card_generator->single('41', 16),
                'type' => $type,
                'support' => $support,
                'debit' => $debit,
                'cvc' => rand(100, 999),
                'code' => base64_encode(rand(1000, 9999)),
                'limit_retrait' => 0,
                'limit_payment' => $limit_payment,
                'customer_wallet_id' => $wallet->id,
            ]);
        }

        return $card;
    }

    public static function getExpiration($card): string
    {
        if ($card->exp_month <= 9) {
            $month = '0'.$card->exp_month;
        } else {
            $month = $card->exp_month;
        }

        return $month.'/'.$card->exp_year;
    }

    public static function getTransactionsMonthWithdraw($card, $percent = false)
    {
        if ($percent == false) {
            return - $card->transactions()
                ->where('type', 'retrait')
                ->where('confirmed', true)
                ->where('customer_credit_card_id', $card->id)
                ->whereBetween('confirmed_at', [now()->subDays(7), now()])
                ->get()
                ->sum('amount');
        } else {
            $tran = - $card->transactions()
                        ->where('type', 'retrait')
                        ->where('confirmed', true)
                        ->where('customer_credit_card_id', $card->id)
                        ->whereBetween('confirmed_at', [now()->subDays(7), now()])
                        ->get()
                        ->sum('amount');

            return $tran * 100 / $card->limit_retrait;
        }
    }

    public static function getTransactionsMonthPayment($card, $percent = false)
    {
        if ($percent == false) {
            return - $card->transactions()
                ->where('type', 'payment')
                ->where('confirmed', true)
                ->where('customer_credit_card_id', $card->id)
                ->whereBetween('confirmed_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->get()
                ->sum('amount');
        } else {
            $tran = - $card->transactions()
                ->where('type', 'payment')
                ->where('confirmed', true)
                ->where('customer_credit_card_id', $card->id)
                ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->get()
                ->sum('amount');

            if ($tran == 0) {
                return 0;
            } else {
                return $tran * 100 / $card->limit_payment;
            }
        }
    }

    public static function getRestantDiffered($card)
    {
        return $card->differed_limit - $card->transactions()->where('differed', 1)->whereBetween('differed_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
    }

    public static function getUsedDiffered($card, $percent = false)
    {
        if (! $percent) {
            return $card->transactions()->where('differed', 1)->whereBetween('differed_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
        } else {
            $used = $card->transactions()->where('differed', 1)->whereBetween('differed_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
            if ($used != 0) {
                return self::getRestantDiffered($card) * 100 / $card->differed_limit;
            } else {
                return 0;
            }
        }
    }
}
