<?php


namespace App\Helper;


class CustomerTransactionHelper
{
    public static function getTypeTransaction($type, $labeled = false, $symbol = false)
    {
        if($symbol == true) {
            switch ($type)
            {
                case 'depot':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Dépot">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/depot.png)"></div>
                            </div>';
                    break;

                case 'retrait':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Retrait">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/retrait.png)"></div>
                            </div>';
                    break;

                case 'payment':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Paiement">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/payment.png)"></div>
                            </div>';
                    break;

                case 'virement':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Virement Bancaire">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/virement.png)"></div>
                            </div>';
                    break;

                case 'sepa':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Prélèvement">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/sepas.png)"></div>
                            </div>';
                    break;

                case 'frais':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Frais Bancaire">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/frais.png)"></div>
                            </div>';
                    break;

                case 'souscription':
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Souscription">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/souscription.png)"></div>
                            </div>';
                    break;

                default:
                    return '<div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" title="Autre">
                                <div class="symbol-label" style="background-image: url(/storage/transaction/autre.png)"></div>
                            </div>';
                    break;
            }
        } elseif ($labeled == true) {
            return '<span class="badge badge-'.random_color().'"></span>';
        } else {
            return \Str::ucfirst($type);
        }
    }
}
