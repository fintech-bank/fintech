<?php


namespace App\Helper;


class CustomerHelper
{
    public static function getTypeCustomerArray()
    {
        return json_encode([
            [
                'name' => "part"
            ],
            [
                'name' => "pro"
            ]
        ]);
    }

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
                case 'suspended': return 'Suspendue'; break;
                case 'closed': return 'Dossier Clotûrer'; break;
                default: return 'Compte Actif'; break;
            }
        } else {
            switch ($status) {
                case 'open': return '<span class="badge badge-primary">Ouverture en cours</span>'; break;
                case 'completed': return '<span class="badge badge-warning">Dossier Complet</span>'; break;
                case 'accepted': return '<span class="badge badge-success">Dossier Accepter</span>'; break;
                case 'declined': return '<span class="badge badge-danger">Dossier Refuser</span>'; break;
                case 'suspended': return '<span class="badge badge-warning">Dossier Suspendue</span>'; break;
                case 'closed': return '<span class="badge badge-danger">Dossier Clotûrer</span>'; break;
                default: return '<span class="badge badge-secondary">Compte Actif</span>'; break;
            }
        }
    }

    public static function getName($customer)
    {
        if ($customer->info->type == 'part') {
            return $customer->info->civility.'. '.$customer->info->lastname.' '.$customer->info->firstname;
        } else {
            return $customer->info->company;
        }
    }

    public static function getFirstname($customer)
    {
        if($customer->info->type == 'pro') {
            return $customer->info->company;
        } else {
            return $customer->info->firstname;
        }
    }

    public static function getAmountAllDeposit($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->where('type', 'depot')->get();
            foreach ($ds as $transaction) {
                $calc += $transaction->amount;
            }
        }

        return eur($calc);
    }

    public static function getAmountAllWithdraw($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->where('type', 'retrait')->get();
            foreach ($ds as $transaction) {
                $calc += $transaction->amount;
            }
        }

        return eur($calc);
    }

    public static function getAmountAllTransfers($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->where('type', 'virement')->orWhere('type', 'sepa')->get();
            foreach ($ds as $transaction) {
                $calc += $transaction->amount;
            }
        }

        return eur($calc);
    }

    public static function getAmountAllTransactions($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets();

        foreach ($wallets->get() as $wallet) {
            $ds = $wallet->transactions()->get()->count();
            $calc += $ds;
        }

        return $calc;
    }

    public static function getCountAllLoan($customer)
    {
        return $customer->prets()->get()->count();
    }

    public static function getCoutAllEpargnes($customer)
    {
        $calc = 0;
        $wallets = $customer->wallets()->get();

        foreach ($wallets as $wallet) {
            $ds = $wallet->epargnes()->get()->count();
            $calc += $ds;
        }

        return $calc;
    }

    public static function getCountAllBeneficiaires($customer)
    {
        return $customer->beneficiaires()->count();
    }
}
