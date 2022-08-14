<?php

namespace App\Helper;

use App\Models\Customer\CustomerMobility;

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
                case 'terminate': return '<span class="badge badge-success badge-sm">Dossier Terminer</span>';
            }
        } elseif ($j == 'comment') {
            switch ($status) {
                case 'bank_start': return 'Votre dossier à été transmis à la banque de départ';
                case 'bank_return': return 'Votre dossier à été traité par la banque de départ et les informations sont dans notre banque';
                case 'creditor_start': return 'Votre dossier à été transmis aux créancier';
                case 'creditor_end': return 'Votre dossier à été traité par vos créancier et les informations sont dans notre banque';
                case 'terminate': return 'Votre dossier est à présent clôturer';
            }
        } else {
            switch ($status) {
                case 'bank_start': return 'Dossier Transmis (banque)';
                case 'bank_return': return 'Dossier Receptionner (banque)';
                case 'creditor_start': return 'Dossier Transmis (Créancier)';
                case 'creditor_end': return 'Dossier Terminer';
            }
        }
    }

    public static function getProgressMobility(CustomerMobility $mobility)
    {
        switch ($mobility->status) {
            case 'bank_start':
                ob_start();
                ?>
                <div class="d-flex flex-column w-100 mt-12">
                    <span class="text-dark me-2 fw-bold pb-3"><?= $mobility->comment ?></span>
                    <div class="progress h-10px w-100">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <?php
                return ob_get_clean();
                break;
            case 'bank_return':
                ob_start();
                ?>
                <div class="d-flex flex-column w-100 mt-12">
                    <span class="text-dark me-2 fw-bold pb-3"><?= $mobility->comment ?></span>
                    <div class="progress h-10px w-100">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <?php
                return ob_get_clean();
                break;

            case 'creditor_start':
                ob_start();
                ?>
                <div class="d-flex flex-column w-100 mt-12">
                    <span class="text-dark me-2 fw-bold pb-3"><?= $mobility->comment ?></span>
                    <div class="progress h-10px w-100">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <?php
                return ob_get_clean();
                break;

            case 'creditor_end':
                ob_start();
                ?>
                <div class="d-flex flex-column w-100 mt-12">
                    <span class="text-dark me-2 fw-bold pb-3"><?= $mobility->comment ?></span>
                    <div class="progress h-10px w-100">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <?php
                return ob_get_clean();
                break;

            case 'terminate':
                ob_start();
                ?>
                <div class="d-flex flex-column w-100 mt-12">
                    <span class="text-dark me-2 fw-bold pb-3"><?= $mobility->comment ?></span>
                    <div class="progress h-10px w-100">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <?php
                return ob_get_clean();
                break;
        }
    }

    /**
     * @param CustomerMobility $mobility
     * @return bool
     */
    public static function documentIsAllValid(CustomerMobility $mobility): bool
    {
        $countAllPrlv = $mobility->prlvs()->count();
        $countValidPrlv = $mobility->prlvs()->where('valid', 1)->count();
        $countAllInc = $mobility->incomings()->count();
        $countValidInc = $mobility->incomings()->where('valid', 1)->count();
        $countAllOut = $mobility->outgoings()->count();
        $countValidOut = $mobility->outgoings()->where('valid', 1)->count();
        $countAllChq = $mobility->cheques()->count();
        $countValidChq = $mobility->cheques()->where('valid', 1)->count();

        if(($countAllPrlv == $countValidPrlv) && ($countAllInc == $countValidInc) && ($countAllOut == $countValidOut) && ($countAllChq == $countValidChq)) {
            return true;
        } else {
            return false;
        }
    }
}
