<?php

namespace App\Http\Controllers\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerTransferHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerTransfer;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Agent\Customer\InitTransferNotification;
use App\Notifications\Customer\InitTransferController;
use App\Services\BankFintech;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * @var BankFintech
     */
    private $bankFintech;

    /**
     * TransferController constructor.
     * @param BankFintech $bankFintech
     */
    public function __construct(BankFintech $bankFintech)
    {
        $this->bankFintech = $bankFintech;
    }

    public function index()
    {
        return view('customer.transfer.index', [
            'customer' => \request()->user()->customers
        ]);
    }

    public function store(Request $request)
    {
        $beneficiaire = CustomerBeneficiaire::find($request->get('customer_beneficiaire_id'));
        $wallet = CustomerWallet::find($request->get('customer_wallet_id'));

        if ($request->get('type') == 'immediat') {
            return $this->immediatTransfer($request, $beneficiaire, $wallet);
        } elseif ($request->get('type') == 'differed') {
            return $this->differedTransfer($request, $beneficiaire, $wallet);
        } else {
            return $this->permanentTransfer($request, $beneficiaire, $wallet);
        }
    }

    public function history()
    {
        return view('customer.transfer.history', [
            'customer' => \request()->user()->customers
        ]);
    }

    public function print($transfer_id)
    {
        $transfer = CustomerTransfer::find($transfer_id);
        $document = new DocumentFile();

        try {
            return $document->generatePDF('agence.transfer', $transfer->wallet->customer, null, ['transfer' => $transfer], false, false, null, true, null);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request, $transfer)
    {
        $transfer = CustomerTransfer::find($transfer);

        try {
            $transfer->update([
                'recurring_end' => $request->get('recurring_end') != $transfer->recurring_end ? $request->get('recurring_end') : $transfer->recurring_end,
                'amount' => $request->get('amount') != $transfer->amount ? $request->get('amount') : $transfer->amount
            ]);

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => $exception], 500);
        }
    }

    public function delete($transfer)
    {
        $transfer = CustomerTransfer::find($transfer);
        $transactions = CustomerTransaction::where('designation', 'LIKE', '%Virement vers '.CustomerTransferHelper::getNameBeneficiaire($transfer->beneficiaire).'%')->whereBetween('updated_at', [$transfer->recurring_start, $transfer->recurring_end])->get();

        foreach ($transactions as $transaction) {
            CustomerTransactionHelper::deleteTransaction($transaction);
        }

        $transfer->delete();

        return response()->json();
    }

    private function immediatTransfer($request, $beneficiaire, $wallet)
    {
        // Vérification de l'état de la banque
        if ($this->bankFintech->callStatusBank($beneficiaire->bank->name) == true) {
            // création du virement
            try {
                $transfer = $wallet->transfers()->create([
                    "uuid" => \Str::uuid(),
                    "amount" => $request->get('amount'),
                    "reference" => \Str::upper(\Str::random()),
                    "reason" => $request->get('reason'),
                    "type" => $request->get('type'),
                    "transfer_date" => now()->startOfDay(),
                    "customer_beneficiaire_id" => $beneficiaire->id,
                    "customer_wallet_id" => $wallet->id
                ]);
            } catch (\Exception $exception) {
                LogHelper::notify('critical', $exception);
                return response()->json(['errors' => $exception], 500);
            }

            try {
                $tr = CustomerTransferHelper::initTransfer($transfer->id);
            } catch (\Exception $exception) {
                LogHelper::notify('critical', $exception);
                return response()->json(['errors' => $exception], 500);
            }

            // Notification
            $agent = $wallet->customer->agent;
            $agent->notify(new InitTransferNotification($tr));

            auth()->user()->notify(new InitTransferController($tr));

            return response()->json([
                "beneficiaire" => CustomerTransferHelper::getNameBeneficiaire($beneficiaire)
            ]);
        } else {
            return response()->json(['errors' => [
                $beneficiaire->bank->name => "La banque distante est actuellement fermé"
            ]], 404);
        }
    }

    private function differedTransfer($request, $beneficiaire, $wallet)
    {
        try {
            $transfer = $wallet->transfers()->create([
                "uuid" => \Str::uuid(),
                "amount" => $request->get('amount'),
                "reference" => \Str::upper(\Str::random()),
                "reason" => $request->get('reason'),
                "type" => $request->get('type'),
                "transfer_date" => $request->get('transfer_date'),
                "customer_beneficiaire_id" => $beneficiaire->id,
                "customer_wallet_id" => $wallet->id
            ]);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => $exception], 500);
        }

        try {
            $tr = CustomerTransferHelper::initTransfer($transfer->id);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => $exception], 500);
        }

        // Notification
        $agent = $wallet->customer->agent;
        $agent->notify(new InitTransferNotification($tr));

        auth()->user()->notify(new InitTransferController($tr));

        return response()->json([
            "beneficiaire" => CustomerTransferHelper::getNameBeneficiaire($beneficiaire)
        ]);
    }

    private function permanentTransfer($request, $beneficiaire, $wallet)
    {
        try {
            $transfer = $wallet->transfers()->create([
                "uuid" => \Str::uuid(),
                "amount" => $request->get('amount'),
                "reference" => \Str::upper(\Str::random()),
                "reason" => $request->get('reason'),
                "type" => $request->get('type'),
                "transfer_date" => null,
                "recurring_start" => $request->get('recurring_start'),
                "recurring_end" => $request->get('recurring_end'),
                "customer_beneficiaire_id" => $beneficiaire->id,
                "customer_wallet_id" => $wallet->id
            ]);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => $exception], 500);
        }

        try {
            $tr = CustomerTransferHelper::programTransfer($transfer->id);
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(['errors' => $exception], 500);
        }

        // Notification
        $agent = $wallet->customer->agent;
        $agent->notify(new InitTransferNotification($tr));

        auth()->user()->notify(new InitTransferController($tr));

        return response()->json([
            "beneficiaire" => CustomerTransferHelper::getNameBeneficiaire($beneficiaire)
        ]);
    }
}
