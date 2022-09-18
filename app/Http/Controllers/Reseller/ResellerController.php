<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWithdraw;
use Illuminate\Http\Request;

class ResellerController extends Controller
{
    public function dashboard()
    {

        return view('reseller.dashboard');
    }

    public function postWithdraw(Request $request)
    {

    }

    public function getWithdraw($id)
    {
        $with = CustomerWithdraw::find($id);
        if ($with->status != 'pending') {
            return response()->json([
                'errors' => [
                    'Vous ne pouvez pas validé un retrait déjà retiré'
                ]
            ], 500);
        } else {
            return response()->json($with);
        }

    }

    public function validWithdraw(Request $request, $with_id)
    {
        $with = CustomerWithdraw::find($with_id);
        if (base64_decode($with->code) == $request->get('code')) {
            $with->transaction()->update([
                'confirmed' => 1,
                'confirmed_at' => now()
            ]);

            $with->update([
                'status' => 'terminated'
            ]);

            return response()->json();
        } else {
            return response()->json([
                'errors' => [
                    'Le code de vérification est érroné'
                ]
            ], 500);
        }
    }
}
