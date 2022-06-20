<?php


namespace App\Services;


class CheckPretService
{
    public function handle($wallet_principal, $customer)
    {
        $v = 0;
        $text = collect();
        /*
         * Vérification des transactions du compte bancaire principal
         * NB: On calcul la moyenne des débits et des crédit si crédit > débit V+1
         */

        $deb = $wallet_principal->transactions()->where('confirmed', true)->where('amount', '<', 0)->avg('amount');
        $cred = $wallet_principal->transactions()->where('confirmed', true)->where('amount', '>', 0)->avg('amount');

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

        if ($wallet_principal->decouvert == 1) {
            $v--;
            $text->add(['decouvert']);
        } else {
            $v++;
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

        $result = $v;

        return [
            "resultat" => $result,
            "text" => $text
        ];
    }
}
