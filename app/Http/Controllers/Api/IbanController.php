<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Selectra;
use Illuminate\Http\Request;

class IbanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $selectra = new Selectra();

        return response()->json($selectra->getBankByIban($request->get('iban')));
    }
}
