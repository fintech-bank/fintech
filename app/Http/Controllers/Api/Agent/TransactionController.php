<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function info($id)
    {
        Carbon::setLocale('fr_FR');
        $transaction = CustomerTransaction::query()->find($id);

        return response()->json([
            'type' => CustomerTransactionHelper::getTypeTransaction($transaction->type),
            'title' => $transaction->designation,
            'dateText' => $transaction->amount < 0 ? "Débité le ".$transaction->updated_at->locale('fr_FR')->format('j F Y') : "Crédité le ".$transaction->updated_at->locale('fr_FR')->format('j F Y'),
            'amount' => $transaction->amount < 0 ? eur($transaction->amount) : "+ ".eur($transaction->amount),
            'description' => $transaction->description != null ? $transaction->description : $transaction->designation,
            'date' => $transaction->updated_at->locale('fr_FR')->format('j F Y'),
            'reference' => $transaction->uuid
        ]);
    }
}
