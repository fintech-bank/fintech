<?php


namespace App\Helper;


class CustomerSepaHelper
{
    public static function getStatus($status, $labeled = true)
    {
        if($labeled == false) {
            switch ($status) {
                case 'waiting': return 'En Attente'; break;
                case 'processed': return 'Traité'; break;
                case 'rejected': return 'Rejeté'; break;
                case 'return': return 'Retourné'; break;
                case 'refunded': return 'Remboursé'; break;
                default: return null;
            }
        } else {
            switch ($status) {
                case 'waiting': return '<span class="badge badge-pill rounded badge-warning">En Attente</span>'; break;
                case 'processed': return '<span class="badge badge-pill rounded badge-success">Traité</span>'; break;
                case 'rejected': return '<span class="badge badge-pill rounded badge-info">Rejeté</span>'; break;
                case 'return': return '<span class="badge badge-pill rounded badge-danger">Retourné</span>'; break;
                case 'refunded': return '<span class="badge badge-pill rounded badge-primary">Remboursé</span>'; break;
                default: return null;
            }
        }
    }
}
