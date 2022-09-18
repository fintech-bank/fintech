<?php

namespace App\Helper;

class CustomerWithdrawHelper
{
    /**
     * @throws \Exception
     */
    public static function getStatusWithdraw($status, $labeled = false): string
    {
        if($labeled) {
            return match ($status) {
                'pending' => '<span class="badge badge-primary badge-sm"><i class="fa-solid fa-spinner fa-spin-pulse me-2"></i> En attente</span>',
                'accepted' => '<span class="badge badge-success badge-sm"><i class="fa-solid fa-check-circle me-2"></i> Accepter</span>',
                'rejected' => '<span class="badge badge-danger badge-sm"><i class="fa-solid fa-xmark-circle me-2"></i> Rejeter</span>',
                'terminated' => '<span class="badge badge-dark badge-sm"><i class="fa-solid fa-check me-2"></i> Terminer</span>',
                default => throw new \Exception('Unexpected value'),
            };
        } else {
            return match ($status) {
                'pending' => 'En attente',
                'accepted' => 'Accepter',
                'rejected' => 'Rejeter',
                'terminated' => 'Terminer',
                default => throw new \Exception('Unexpected value'),
            };
        }
    }

    /**
     * @param int $status
     * @param bool $labeled
     * @return string
     */
    public static function getStatusDab(int $status, bool $labeled = false): string
    {
        if ($labeled) {
            return match ($status) {
                1 => '<span class="badge badge-success badge-sm"><i class="fa-solid fa-check-circle me-2"></i> Ouvert</span>',
                0 => '<span class="badge badge-danger badge-sm"><i class="fa-solid fa-xmark-circle me-2"></i> Fermer</span>'
            };
        } else {
            return match ($status) {
                1 => 'Ouvert',
                0 => 'Fermer'
            };
        }
    }
}
