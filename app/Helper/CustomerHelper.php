<?php


namespace App\Helper;


class CustomerHelper
{
    public static function getTypeCustomer($type, $labeled = false)
    {
        if ($labeled == false) {
            switch ($type) {
                case 'part':
                    return 'Particulier';
                default:
                    return 'Professionnel';
            }
        } else {
            switch ($type) {
                case 'part':
                    return '<span class="badge badge-primary">Particulier</span>';
                default:
                    return '<span class="badge badge-danger">Professionnel</span>';
            }
        }
    }

    public static function getVerified($verified)
    {
        if ($verified == 1) {
            return '<i class="fa fa-check-circle fa-lg text-success"></i>';
        } else {
            return '<i class="fa fa-times-circle fa-lg text-danger"></i>';
        }
    }

    public static function getStatusOpenAccount($status, $labeled = false)
    {
        if ($labeled == false) {
            switch ($status) {
                case 'open': return 'Ouverture en cours'; break;
                case 'completed': return 'Dossier Complet'; break;
                case 'accepted': return 'Dossier Accepter'; break;
                case 'declined': return 'Dossier Refuser'; break;
                default: return 'Compte Actif'; break;
            }
        } else {
            switch ($status) {
                case 'open': return '<span class="badge badge-primary">Ouverture en cours</span>'; break;
                case 'completed': return '<span class="badge badge-warning">Dossier Complet</span>'; break;
                case 'accepted': return '<span class="badge badge-success">Dossier Accepter</span>'; break;
                case 'declined': return '<span class="badge badge-danger">Dossier Refuser</span>'; break;
                default: return '<span class="badge badge-secondary">Compte Actif</span>'; break;
            }
        }
    }
}
