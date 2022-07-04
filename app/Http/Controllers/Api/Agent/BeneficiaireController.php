<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerTransferHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerBeneficiaire;
use Illuminate\Http\Request;

class BeneficiaireController extends Controller
{
    public function info($beneficiaire)
    {
        $info = CustomerBeneficiaire::find($beneficiaire);

        return response()->json([
            'name' => CustomerTransferHelper::getNameBeneficiaire($info)
        ]);
    }
}
