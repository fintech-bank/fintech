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
            'name' => CustomerTransferHelper::getNameBeneficiaire($info),
            'beneficiaire' => $info,
        ]);
    }

    public function search(Request $request)
    {
        $query = CustomerBeneficiaire::query()->where('customer_id', $request->get('customer_id'))
            ->where('company', 'LIKE', '%'.$request->get('search').'%')
            ->orWhere('firstname', 'LIKE', '%'.$request->get('search').'%')
            ->orWhere('lastname', 'LIKE', '%'.$request->get('search').'%')
            ->get();

        $all = CustomerBeneficiaire::query()->where('customer_id', $request->get('customer_id'))->get();

        $arr = [];

        foreach ($query as $item) {
            $arr[] = [
                'id' => $item->id,
                'full_name' => $item->full_name,
                'bankname' => $item->bankname,
                'iban' => $item->iban,
            ];
        }

        return response()->json([
            'beneficiaires' => $arr,
            'all' => $all,
        ]);
    }
}
