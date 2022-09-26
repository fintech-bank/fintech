<?php

namespace App\Helper;

use App\Models\Core\LoanPlan;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Notifications\Agent\Customer\CreatePretNotification;
use Carbon\Carbon;

class CustomerLoanHelper
{
    public static function getLoanInterest($amount_loan, $interest_percent)
    {
        return $amount_loan * $interest_percent / 100;
    }

    public static function getTypeLoan($type)
    {
    }

    public static function getStatusLoan($status, $labeled = true)
    {
        if ($labeled == true) {
            switch ($status) {
                case 'open':
                    return "<span class='badge badge-secondary badge-lg'><i class='fa-solid fa-pencil me-3'></i> Nouveau dossier</span>";
                    break;
                case 'study':
                    return "<span class='badge badge-warning badge-lg'><i class='fa-solid fa-file me-3'></i> Traitement de la demande</span>";
                    break;
                case 'accepted':
                    return "<span class='badge badge-success badge-lg'><i class='fa-solid fa-check-circle me-3'></i> Accepter</span>";
                    break;
                case 'refused':
                    return "<span class='badge badge-danger badge-lg'><i class='fa-solid fa-times-circle me-3'></i> Refuser</span>";
                    break;
                case 'progress':
                    return "<span class='badge badge-success badge-lg'><i class='fa-solid fa-spinner fa-spin me-3'></i> Utilisation en cours</span>";
                    break;
                case 'terminated':
                    return "<span class='badge badge-info badge-lg'><i class='fa-solid fa-check fa-spin me-3'></i> Pret rembourser</span>";
                    break;
                case 'error':
                    return "<span class='badge badge-danger badge-lg'><i class='fa-solid fa-exclamation-triangle fa-spin me-3'></i> Erreur</span>";
                    break;
            }
        } else {
            switch ($status) {
                case 'open':
                    return 'Nouveau dossier';
                    break;
                case 'study':
                    return 'Traitement de la demande';
                    break;
                case 'accepted':
                    return 'Accepter';
                    break;
                case 'refused':
                    return 'Refuser';
                    break;
                case 'progress':
                    return 'Utilisation en cours';
                    break;
                case 'terminated':
                    return 'Pret rembourser';
                    break;
                case 'error':
                    return 'Erreur';
                    break;
            }
        }
    }

    public static function calcRestantDu($loan, $euro = true)
    {
        if ($euro == true) {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');
            $calc = $loan->amount_du - $prlv_effect;

            return eur($calc);
        } else {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');

            return $loan->amount_du - $prlv_effect;
        }
    }

    public static function createLoan($wallet, $customer, $amount, $loan_plan, $duration, $prlv_day = 20, $status = 'open', $card = null)
    {
        $plan = LoanPlan::find($loan_plan);

        $wallet_pret = CustomerWalletHelper::createWallet($customer, 'pret');

        $loan = CustomerPret::query()->create([
            'uuid' => \Str::uuid(),
            'reference' => \Str::upper(\Str::random(8)),
            'amount_loan' => $amount,
            'amount_interest' => self::getLoanInterest($amount, $plan->interests[0]->interest),
            'amount_du' => $amount + self::getLoanInterest($amount, $plan->interests[0]->interest),
            'mensuality' => ($amount + self::getLoanInterest($amount, $plan->interests[0]->interest)) / $duration,
            'prlv_day' => $prlv_day,
            'duration' => $duration,
            'status' => $status,
            'signed_customer' => 1,
            'signed_bank' => 1,
            'customer_wallet_id' => $wallet_pret->id,
            'wallet_payment_id' => $wallet->id,
            'first_payment_at' => Carbon::create(now()->year, now()->addMonth()->month, $prlv_day),
            'loan_plan_id' => $loan_plan,
            'customer_id' => $customer->id,
        ]);

        if ($plan->id == 8) {
            $facelia = CustomerFacelia::query()->create([
                'reference' => CustomerFaceliaHelper::generateReference(),
                'amount_available' => $amount,
                'amount_interest' => 0,
                'amount_du' => 0,
                'mensuality' => 0,
                'wallet_payment_id' => $wallet->id,
                'customer_pret_id' => $loan->id,
                'customer_credit_card_id' => $card,
                'customer_wallet_id' => $loan->wallet->id,
            ]);

            $doc_pret = DocumentFile::createDoc(
                $customer,
                'Contrat de credit facelia',
                $loan->reference.' - Information Contractuel Facelia',
                3,
                null,
                true,
                true,
                true,
                true,
                [
                    'loan' => $loan,
                    'facelia' => $facelia,
                ]
            );
        } else {
            $doc_pret = DocumentFile::createDoc(
                $customer,
                'Contrat de credit Personnel',
                $loan->reference.' - Offre de contrat de credit Pret Personnel',
                3,
                null,
                true,
                true,
                false,
                true,
                [
                    'loan' => $loan,
                ]
            );
        }

        DocumentFile::createDoc(
            $customer,
            'Fiche de Dialogue',
            $loan->reference.' - Fiche de Dialogue',
            3,
            null,
            false,
            false,
            false,
            true,
            []
        );

        DocumentFile::createDoc(
            $customer,
            'Information Precontractuel Normalise',
            $loan->reference.' - Information Precontractuel Normalise',
            3,
            null,
            true,
            true,
            true,
            true,
            [
                'loan' => $loan,
            ]
        );

        DocumentFile::createDoc(
            $customer,
            'Assurance Emprunteur',
            $loan->reference.' - Assurance Emprunteur',
            3,
            null,
            false,
            false,
            false,
            true,
            []
        );

        DocumentFile::createDoc(
            $customer,
            'Avis de conseil relatif assurance',
            $loan->reference.' - Avis de conseil relatif à un produit d\'assurance',
            3,
            null,
            false,
            false,
            false,
            true,
            []
        );
        DocumentFile::createDoc(
            $customer,
            'Mandat Prelevement Sepa',
            $loan->reference.' - Mandat Prelevement Sepa',
            3,
            null,
            false,
            false,
            false,
            true,
            [
                'loan' => $loan,
            ]
        );
        DocumentFile::createDoc(
            $customer,
            'Plan d\'amortissement',
            $loan->reference.' - Plan d\'amortissement',
            3,
            null,
            false,
            false,
            false,
            true,
            [
                'loan' => $loan,
            ]
        );

        if(auth()->user()->agent == 1) {
            auth()->user()->notify(new CreatePretNotification($customer, $wallet, $doc_pret));
        }
        $customer->user->notify(new \App\Notifications\Customer\CreatePretNotification($customer, $wallet, $doc_pret, $loan));

        return $loan;
    }

    public static function calcMensuality($total_amount, $duration, $plan, $assurance = 'D')
    {
        $ass = self::getLoanInsurance($assurance);

        $subtotal = $total_amount + ($ass * $duration);
        $subInterest = self::getLoanInterest($total_amount, $plan->interests[0]->interest);
        $int_mensuality = $subInterest / $duration;

        return ($subtotal / $duration) + $int_mensuality;
    }

    public static function getLoanInsurance($insurance)
    {
        switch ($insurance) {
            case 'D': $ass = 3.50;
                break;
            case 'DIM': $ass = 4.90;
                break;
            default: $ass = 7.90;
                break;
        }

        return $ass;
    }

}
