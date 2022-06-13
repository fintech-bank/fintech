<?php


namespace App\Helper;


class CustomerWalletHelper
{
    public static function getTypeWallet($type, $label = false)
    {
        if($label == true) {
            switch ($type) {
                case 'pret': return '<span class="badge badge-primary">Pret Bancaire</span>'; break;
                case 'compte': return '<span class="badge badge-success">Compte Courant</span>'; break;
                default: return '<span class="badge badge-success">Compte Epargne</span>'; break;
            }
        } else {
            switch ($type) {
                case 'pret': return 'Pret Bancaire'; break;
                case 'compte': return 'Compte Courant'; break;
                default: return 'Compte Epargne'; break;
            }
        }
    }

    public static function getStatusWallet($type, $label = false)
    {
        if($label == true) {
            switch ($type) {
                case 'pending': return '<span class="badge badge-primary">En attente</span>'; break;
                case 'active': return '<span class="badge badge-success">Actif</span>'; break;
                case 'suspended': return '<span class="badge badge-warning">Suspendue</span>'; break;
                default: return '<span class="badge badge-danger">Clotûrer</span>'; break;
            }
        } else {
            switch ($type) {
                case 'pending': return 'En attente'; break;
                case 'active': return 'Actif'; break;
                case 'suspended': return 'Suspendue'; break;
                default: return 'Clotûrer'; break;
            }
        }
    }

    public static function getNameAccount($wallet)
    {
        return CustomerHelper::getName($wallet->customer).' - Compte courant N°'.$wallet->number_account;
    }
}
