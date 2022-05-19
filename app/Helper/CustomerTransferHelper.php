<?php


namespace App\Helper;


class CustomerTransferHelper
{
    public static function getNameBeneficiaire($beneficiaire)
    {
        if ($beneficiaire->type == 'corporate') {
            return $beneficiaire->company;
        } else {
            return $beneficiaire->civility . '. ' . $beneficiaire->firstname . ' ' . $beneficiaire->lastname;
        }
    }

    public static function getTypeTransfer($type)
    {
        switch ($type) {
            case 'immediat':
                return 'Immédiat';
                break;
            case 'differed':
                return 'Differé';
                break;
            case 'permanent':
                return 'Permanent';
                break;
            default:
                return "Inconnue";
                break;
        }
    }

    public static function getStatusTransfer($status, $labeled = false)
    {
        if ($labeled == false) {
            switch ($status) {
                case 'paid': return 'Executer'; break;
                case 'pending': return 'En Attente'; break;
                case 'in_transit': return 'En cours d\'exécution'; break;
                case 'canceled': return 'Annuler'; break;
                case 'failed': return 'Rejeter'; break;
                default: return 'Inconnue'; break;
            }
        } else {
            switch ($status) {
                case 'paid': return '<span class="badge badge-success"><i class="fa-solid fa-check me-2"></i> Exécuter</span>'; break;
                case 'pending': return '<span class="badge badge-warning"><i class="fa-solid fa-spinner fa-spin-pulse me-2"></i> En attente</span>'; break;
                case 'in_transit': return '<span class="badge badge-warning"><i class="fa-solid fa-spinner fa-spin-pulse me-2"></i> En cours d\'exécution</span>'; break;
                case 'canceled': return '<span class="badge badge-info"><i class="fa-solid fa-times me-2"></i> Annuler</span>'; break;
                case 'failed': return '<span class="badge badge-danger"><i class="fa-solid fa-triangle-exclamation fa-beat-fade me-2"></i> Rejeter</span>'; break;
                default: return '<span class="badge badge-info"><i class="fa-solid fa-triangle-exclamation fa-beat-fade me-2"></i> Inconnue</span>'; break;
            }
        }
    }
}
