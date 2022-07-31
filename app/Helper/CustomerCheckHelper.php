<?php

namespace App\Helper;

class CustomerCheckHelper
{
    public static function getStatus($status, $labeled = true)
    {
        if ($labeled == false) {
            switch ($status) {
                case 'checkout': return 'Chéquier commandé';
                    break;
                case 'manufacture': return 'En cours de fabrication';
                    break;
                case 'ship': return 'En cours de transport';
                    break;
                case 'outstanding': return 'Utilisation en cours';
                    break;
                case 'finish': return 'Chéquier terminé';
                    break;
                default: return 'Chéquier Détruit';
                    break;
            }
        } else {
            switch ($status) {
                case 'checkout': return '<span class="badge badge-pill rounded badge-primary"><i class="fa-solid fa-shopping-basket me-3"></i> Chéquier commandé</span>';
                    break;
                case 'manufacture': return '<span class="badge badge-pill rounded badge-info"><i class="fa-solid fa-spinner fa-spin-pulse me-3"></i> En cours de fabrication</span>';
                    break;
                case 'ship': return '<span class="badge badge-pill rounded badge-warning"><i class="fa-solid fa-truck-pickup fa-bounce me-3"></i> En cours de transport</span>';
                    break;
                case 'outstanding': return '<span class="badge badge-pill rounded badge-success"><i class="fa-solid fa-check-circle me-3"></i> Utilisation en cours</span>';
                    break;
                case 'finish': return '<span class="badge badge-pill rounded badge-danger"><i class="fa-solid fa-times-circle me-3"></i> Chéquier terminé</span>';
                    break;
                default: return '<span class="badge badge-pill rounded badge-danger"><i class="fa-solid fa-trash me-3"></i> Chéquier détruit</span>';
                    break;
            }
        }
    }
}
