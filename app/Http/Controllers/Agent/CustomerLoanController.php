<?php

namespace App\Http\Controllers\Agent;

use App\Helper\CustomerTransactionHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Agent\Customer\UpdateStatusLoanNotification;
use Illuminate\Http\Request;

class CustomerLoanController extends Controller
{
    /**
     * Vérification Primaire de la demande de pret
     * @param $customer
     * @param $wallet
     * @param $loan
     */
    public function check($customer, $wallet, $loan)
    {
        $v = 0;
        $loan = CustomerPret::find($loan);
        $wallet = CustomerWallet::find($loan->wallet_payment_id);
        $customer = $wallet->customer;
        $text = collect();

        /*
         * Vérification des transactions du compte bancaire principal
         * NB: On calcul la moyenne des débits et des crédit si crédit > débit V+1
         */

        $deb = $wallet->transactions()->where('confirmed', true)->where('amount', '<', 0)->avg('amount');
        $cred = $wallet->transactions()->where('confirmed', true)->where('amount', '>', 0)->avg('amount');

        $cred > $deb ? $v++ : $v--;
        if ($cred > $deb) {
            $v++;
        } else {
            $v--;
            $text->add(['transactions']);
        }

        /*
         * Vérification du nombre de pret bancaire
         * Si == 0 $v++
         */

        $loans = $customer->prets()->where('status', 'terminated')->count();
        $loans == 0 ? $v++ : $v--;
        if ($loans == 0) {
            $v += 2;
        } elseif ($loans >= 1 && $loans <= 3) {
            $v++;
        } else {
            $v--;
            $text->add(['loans']);
        }

        /*
         * Vérifie si le client à déja un découvert
         * si oui $v--
         */

        $wallet->decouvert == 1 ? $v-- : $v++;
        if ($wallet->decouvert == 1) {
            $v--;
            $text->add(['decouvert']);
        }


        /*
         * Vérifie le salaire du client
         * si <= 500 = $v--
         * si > 500 & <= 1500 = $v++;
         * si > 1500 = $v += 2;
         */

        if ($customer->income->pro_incoming <= 500) {
            $v--;
            $text->add(['incoming']);
        } elseif ($customer->income->pro_incoming > 500 && $customer->income->pro_incoming <= 1500) {
            $v++;
        } else {
            $v += 2;
        }

        /*
         * Vérification de la cotation client
         */

        if ($customer->cotation <= 4) {
            $v--;
            $text->add(['cotation']);
        } elseif ($customer->cotation > 4 && $customer->cotation <= 6) {
            $v++;
        } else {
            $v += 2;
        }

        /*
         * Vérification FICP
         */

        if ($customer->ficp == true) {
            $v--;
            $text->add(['ficp']);
        } else {
            $v++;
        }

        $result = $v * 2;

        return response()->json([
            "resultat" => $result,
            "text" => $text
        ]);

    }

    /**
     * Mise à jour du status du pret manuel
     * @param Request $request
     * @param $customer
     * @param $wallet
     * @param $loan
     */
    public function status(Request $request, $customer, $wallet, $loan)
    {
        try{
            $loan = CustomerPret::find($loan);
            //dd($loan->wallet);

            $loan->update([
                'status' => $request->get('status')
            ]);

            /*
             * si le pret est passer à accepter
             */

            if($request->get('status') == 'accepted') {
                $loan->wallet->update([
                    'status' => 'active'
                ]);

                CustomerTransactionHelper::create('credit',
                    'autre',
                    'Attribution de la somme du pret N°'.$loan->reference,
                    $loan->amount_loan,
                    $loan->wallet->id,
                    false,
                    'Pret N°'.$loan->reference);
            }

            if($request->get('status') == 'refused') {
                $loan->wallet->update([
                    'status' => 'closed'
                ]);
            }

            // Notification
            auth()->user()->notify(new UpdateStatusLoanNotification($loan->customer, $loan, $request->get('status')));
            $loan->customer->user->notify(new \App\Notifications\Customer\UpdateStatusLoanNotification($loan->customer, $loan, $request->get('status')));

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
