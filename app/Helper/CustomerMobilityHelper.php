<?php

namespace App\Helper;

class CustomerMobilityHelper
{
    public static function getStatus($status, $j = null)
    {
        if($j == 'label') {
            switch ($status) {
                case 'bank_start': return '<span class="badge badge-danger badge-sm">Dossier Transmis (banque)</span>';
                case 'bank_return': return '<span class="badge badge-success badge-sm">Dossier Receptionner (banque)</span>';
                case 'creditor_start': return '<span class="badge badge-danger badge-sm">Dossier Transmis (Créancier)</span>';
                case 'creditor_end': return '<span class="badge badge-success badge-sm">Dossier Receptionner (Créancier)</span>';
            }
        } elseif ($j == 'comment') {
            switch ($status) {
                case 'bank_start': return 'Votre dossier à été transmis à la banque de départ';
                case 'bank_return': return 'Votre dossier à été traité par la banque de départ et les informations sont dans notre banque';
                case 'creditor_start': return 'Votre dossier à été transmis aux créancier';
                case 'creditor_end': return 'Votre dossier à été traité par vos créancier et les informations sont dans notre banque';
            }
        } else {
            switch ($status) {
                case 'bank_start': return 'Dossier Transmis (banque)';
                case 'bank_return': return 'Dossier Receptionner (banque)';
                case 'creditor_start': return 'Dossier Transmis (Créancier)';
                case 'creditor_end': return 'Dossier Receptionner (Créancier)';
            }
        }
    }
}
