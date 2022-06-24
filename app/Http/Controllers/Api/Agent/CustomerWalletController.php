<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function chartSummary($wallet_id)
    {
        $wallet = CustomerWallet::with('transactions')->find($wallet_id);
        $debit[] = [
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-01-01 00:00:00', now()->year.'-01-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-02-01 00:00:00', now()->year.'-02-28 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-03-01 00:00:00', now()->year.'-03-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-04-01 00:00:00', now()->year.'-04-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-05-01 00:00:00', now()->year.'-05-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-06-01 00:00:00', now()->year.'-06-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-07-01 00:00:00', now()->year.'-07-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-08-01 00:00:00', now()->year.'-08-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-09-01 00:00:00', now()->year.'-09-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-10-01 00:00:00', now()->year.'-10-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-11-01 00:00:00', now()->year.'-11-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-12-01 00:00:00', now()->year.'-12-31 00:00:00'])->sum('amount'),
        ];

        $credit[] = [
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-01-01 00:00:00', now()->year.'-01-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-02-01 00:00:00', now()->year.'-02-28 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-03-01 00:00:00', now()->year.'-03-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-04-01 00:00:00', now()->year.'-04-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-05-01 00:00:00', now()->year.'-05-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-06-01 00:00:00', now()->year.'-06-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-07-01 00:00:00', now()->year.'-07-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-08-01 00:00:00', now()->year.'-08-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-09-01 00:00:00', now()->year.'-09-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-10-01 00:00:00', now()->year.'-10-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-11-01 00:00:00', now()->year.'-11-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-12-01 00:00:00', now()->year.'-12-31 00:00:00'])->sum('amount'),
        ];

        $decouvert[] = [
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert,
            "-".$wallet->balance_decouvert
        ];

        return response()->json([
            'debit' => $debit,
            'credit' => $credit,
            'decouvert' => $decouvert
        ]);

    }

    public function getBeneficiaire(Request $request, $id)
    {
        $beneficiaire = CustomerBeneficiaire::query()->find($id);
        $wallet = CustomerWallet::query()->find($request->get('wallet'));

        return response()->json(['beneficiaire' => $beneficiaire, 'url' => route('agent.customer.wallet.beneficiaire.update', [$wallet->customer_id, $wallet->id, $beneficiaire->id])]);
    }

    public function info($wallet_id)
    {
        $wallet = CustomerWallet::find($wallet_id);


        return response()->json([
            'wallet' => $wallet,
            'type' => CustomerWalletHelper::getTypeWallet($wallet->type),
            'agency' => $wallet->customer->user->agency,
            'customer' => \Str::limit(CustomerHelper::getName($wallet->customer), 15, '...'),
            'rib' => '/api/wallet/'.$wallet_id.'/rib'
        ]);
    }

    public function rib($wallet_id, DocumentFile $documentFile)
    {
        $wallet = CustomerWallet::find($wallet_id);

        return $documentFile->generatePDF('agence.rib', $wallet->customer, null, ['wallet' => $wallet]);
    }

    public function export(Request $request, $wallet, DocumentFile $documentFile)
    {
        $start = Carbon::createFromTimestamp(strtotime($request->get('start')));
        $end = Carbon::createFromTimestamp(strtotime($request->get('end')));
        $wallet = CustomerWallet::find($wallet);

        $transactions = $wallet->transactions()->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'desc')->get();
        $sum_first = $wallet->balance_actual - $wallet->transactions()->whereBetween('created_at', [$start, $end])->sum('amount');
        $first = $wallet->transactions()->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'asc')->first();

        return $documentFile->generatePDF('agence.exportTransaction', $wallet->customer, null, [
            'transactions' => $transactions,
            "wallet" => $wallet,
            "sum_first" => $sum_first,
            "sum_first_name" => $sum_first < 0 ? 'debiteur' : 'crediteur',
            'first' => $first,
            'start' => $start,
            'end' => $end,
            'sum_last_name' => $wallet->balance_actual < 0 ? 'debiteur' : 'crediteur'
        ]);
    }
}
