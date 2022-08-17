<?php

namespace App\Http\Controllers\Customer;

use App\Helper\CustomerMobilityHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Bank;
use App\Models\Core\LoanPlan;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerMobility;
use App\Notifications\Agent\Customer\UpdateTypeAccountNotification;
use App\Notifications\Customer\SendCodeToSignEmailNotification;
use App\Notifications\Customer\SendCodeToSignSMSNotification;
use Illuminate\Http\Request;
use Intervention\Validation\Rules\Iban;

class SubscriptionController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customers;

        return view('customer.subscription.index', compact('customer'));
    }

    public function updateAccount(Request $request, DocumentFile $documentFile)
    {
        $customer = Customer::find(auth()->user()->customers->id);

        try {
            if ($customer->package_id != $request->get('package')) {
                $customer->package_id = $request->get('package');
                $customer->save();

                $package = Package::find($request->get('package'));

                try {
                    $documentFile->createDocument('Avenant Contrat Particulier', $customer, 3, null, true, true, true, now(), true, 'agence.convention_part');
                } catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json($exception->getMessage(), 500);
                }

                // Notification Agent
                $customer->agent->notify(new UpdateTypeAccountNotification($customer, $package));

                // Notification Client
                $customer->user->notify(new \App\Notifications\Customer\UpdateTypeAccountNotification($customer, $package));

                return response()->json();
            } else {
                return response()->json([
                    'errors' => ["Compte Souscrit" => "Impossible de souscrire au package déjà souscrit"],
                    'type' => 'warning'
                ], 500);
            }
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function mobility(Request $request, DocumentFile $documentFile)
    {
        $request->validate([
            'old_iban' => new Iban(),
            'end_prlv' => 'required|date',
            'customer_wallet_id' => 'required'
        ]);

        $bank = Bank::where('bic', $request->get('old_bic'))->first();
        $customer = auth()->user()->customers;
        $code = rand(100000,999999);
        $serach_iban = CustomerMobility::where('old_iban', $request->get('old_iban'))->exists();
        $mandate = "MDB-".$request->get('old_bic').'T'.$request->user()->agency->bic.now()->format('dmY').'-'.rand(10000,99999);

        if($serach_iban) {
            return response()->json([
                'errors' => ["Mobilité Bancaire" => "Ce compte fait déjà l'objet d'un transfert de banque"],
                'type' => 'warning'
            ], 500);
        }

        try {
            $mobility = $customer->mobilities()->create([
                'status' => 'bank_start',
                'old_iban' => str_replace(' ', '', $request->get('old_iban')),
                'old_bic' => $request->get('old_bic'),
                'mandate' => $mandate,
                'start' => now(),
                'end_prov' => now()->addDays(22)->startOfDay(),
                'close_account' => $request->get('close_account') == 1 ? 1 : 0,
                'customer_id' => $request->user()->customers->id,
                'bank_id' => $bank->id,
                'customer_wallet_id' => $request->get('customer_wallet_id'),
                'comment' => CustomerMobilityHelper::getStatus('bank_start', 'comment'),
                'code' => base64_encode($code)
            ]);

            try {
                $document = DocumentFile::createDoc($customer, 'mandate mobility', 'Mandat de mobilité bancaire - '.$mandate, 3, $mandate,
                true, true, false, true, ['mobility' => $mobility]);
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception);
                return response()->json($exception->getMessage(), 500);
            }

            if(config('app.env') == 'local') {
                auth()->user()->notify(new SendCodeToSignEmailNotification($document, $code));
            } else {
                auth()->user()->notify(new SendCodeToSignSMSNotification($document, $code));
            }

            return response()->json(compact('mobility', 'document'));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function mobilitySignate(Request $request, DocumentFile $documentFile)
    {
        $document = CustomerMobility::find($request->get('document_id'));
        $file = CustomerDocument::where('reference', $document->mandate)->first();
        if($request->get('code') == base64_decode($document->code)) {
            $file->signedByClient();
            return response()->json();
        } else {
            return response()->json(['errors' => [
                "Le code de vérification est invalide"
            ]], 500);
        }
    }

    public function personnalSimulate()
    {
        $customer = auth()->user()->customers;
        $loan_plan = LoanPlan::where('name', 'LIKE', '%Crédit Personnel%')->first();

        return view('customer.subscription.loan.personnalSimulate', compact('customer', 'loan_plan'));
    }
}
