<?php


namespace App\Helper;


class CustomerTransferHelper
{
    public static function getNameBeneficiaire($beneficiaire)
    {
        if($beneficiaire->type == 'corporate') {
            return $beneficiaire->company;
        } else {
            return $beneficiaire->civility.'. '.$beneficiaire->firstname.' '.$beneficiaire->lastname;
        }
    }
}
