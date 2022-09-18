<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWithdrawDab;
use Illuminate\Http\Request;

class DabController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $dab = CustomerWithdrawDab::find($request->get('dab'));

        return response()->json($dab);
    }
}
