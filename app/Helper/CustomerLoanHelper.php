<?php


namespace App\Helper;


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
                    return "Nouveau dossier";
                    break;
                case 'study':
                    return "Traitement de la demande";
                    break;
                case 'accepted':
                    return "Accepter";
                    break;
                case 'refused':
                    return "Refuser";
                    break;
                case 'progress':
                    return "Utilisation en cours";
                    break;
                case 'terminated':
                    return "Pret rembourser";
                    break;
                case 'error':
                    return "Erreur";
                    break;
            }
        }
    }
}
