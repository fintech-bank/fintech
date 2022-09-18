<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerWalletHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCreditCard;
use App\Notifications\Agent\RequestOppositCardNotification;
use Illuminate\Http\Request;

class CustomerCreditCardController extends Controller
{
    public function activate($card)
    {
        $card = CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => 'active',
            ]);

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json(['errors' => [$exception->getMessage()]], 500);
        }
    }

    public function desactivate($card)
    {
        $card = CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => 'inactive',
            ]);

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json(['errors' => [$exception->getMessage()]], 500);
        }
    }

    public function opposit(Request $request, $card)
    {
        $card = CustomerCreditCard::find($card);

        try {
            $card->update([
                'status' => 'inactive',
            ]);

            $card->wallet->customer->agent->notify(new RequestOppositCardNotification($card->wallet->customer, $card, $request->get('type_opposit')));

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);

            return response()->json(['errors' => [$exception->getMessage()]], 500);
        }
    }

    /**
     * Vérifie les informations relatives à la demande de retrait bancaire
     * Vérifie que le compte lié à la carte est actif et le solde poisitif
     * Vérifie que la carte est active
     * Vérifie que la limite de retrait est acceptable
     * On affiche la limite sur 7 jours
     * On affiche l'utilisation sur 7 jours
     * On affiche le montant de retrait possible
     *
     * @param Request $request
     * @param $card
     * @return void
     */
    public function requestWithdraw(Request $request, $card)
    {
        $card = CustomerCreditCard::find($card);
        //dd(CustomerWalletHelper::getSoldeRemaining($card->wallet));
        session()->put('withdraw_request', []);
        // Compte actif
        if($card->wallet->status == 'active') {
            session()->push('withdraw_request.account_status', true);
        } else {
            session()->push('withdraw_request.account_status', false);
        }

        // Solde positif
        if(CustomerWalletHelper::getSoldeRemaining($card->wallet) <= 0) {
            session()->push('withdraw_request.account_solde', false);
        } else {
            session()->push('withdraw_request.account_solde', true);
        }

        // Carte active
        if($card->status == 'active') {
            session()->push('withdraw_request.card_status', true);
        } else {
            session()->push('withdraw_request.card_status', false);
        }

        // Limite de retrait acceptable
        //dd(($card->limit_retrait - \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card)));
        if(($card->limit_retrait - \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card)) <= 9) {
            session()->push('withdraw_request.accept_withdraw', false);
        } else {
            session()->push('withdraw_request.accept_withdraw', true);
        }

        session()->push('withdraw_request.limit_withdraw', $card->limit_retrait);
        session()->push('withdraw_request.limit_used_withdraw', \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card));
        session()->push('withdraw_request.withdraw_u', $card->limit_retrait - \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card));
        session()->push('withdraw_request.limit_used_withdraw_percent', \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card, true));


        return session()->get('withdraw_request');
    }
}
