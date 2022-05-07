<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Notifications\Agent\Customer\UpdateStatusAccountNotification;
use App\Notifications\Agent\Customer\UpdateTypeAccountNotification;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function verifAllSolde($customer_id)
    {
        $customer = Customer::find($customer_id);
        $wallets = [];

        foreach ($customer->wallets as $wallet) {
            if($wallet->balance_actual <= 0 && $wallet->decouvert == 0) {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "outdated"
                ];
            } else {
                $wallets[] = [
                    "compte" => $wallet->number_account,
                    "status" => "ok"
                ];
            }
        }

        return $wallets;
    }

    public function updateStatus(Request $request, $customer_id, DocumentFile $documentFile)
    {
        $customer = Customer::find($customer_id);

        if($request->get('status_open_account') == 'closed') {
            $document = $documentFile->createDocument('Cloture du compte', $customer, 5, null, false, false, false, null, false);
            $documentFile->generatePDF(
                'agence.account_close',
                $customer,
                $document->id,
                [],
                false,
                true,
                '/storage/gdd/'.$customer_id.'/courriers/', false, 'address');
        }

        try {
            $customer->status_open_account = $request->get('status_open_account');
            $customer->save();

            // Notification Agent
            auth()->user()->notify(new UpdateStatusAccountNotification($customer, $request->get('status_open_account')));

            // Notification Client
            $customer->user->notify(new \App\Notifications\Customer\UpdateStatusAccountNotification($customer, $request->get('status_open_account'), null, 'Cloture du compte - CUS'.$customer->user->identifiant.'.pdf'));

            // response
            LogHelper::notify('notice', "Mise à jour du status du compte client: ".CustomerHelper::getName($customer));
            return response()->json([
                "status" => CustomerHelper::getStatusOpenAccount($request->get('status_open_account'))
            ]);
        }catch (\Exception $exception) {
            LogHelper::notify('error', $exception->getMessage());
            return response()->json();
        }
    }

    public function updateTypeAccount(Request $request, $customer_id, DocumentFile $documentFile)
    {
        $customer = Customer::find($customer_id);
        try {
            if($customer->package_id != $request->get('package_id')) {
                $customer->package_id = $request->get('package_id');
                $customer->save();
                $package = Package::find($request->get('package_id'));

                $document = $documentFile->createDocument('Avenant Contrat Particulier', $customer, 3, null, true, true, true, now(), true, 'agence.convention_part');

                // Notification Agent
                auth()->user()->notify(new UpdateTypeAccountNotification($customer, $package));

                // Notification Client
                $customer->user->notify(new \App\Notifications\Customer\UpdateTypeAccountNotification($customer, $package));
            }

            return response()->json();
        }catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
