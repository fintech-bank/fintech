<?php

namespace App\Http\Controllers\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerTransferHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Bank;
use App\Models\Customer\CustomerCreditor;
use App\Models\Customer\CustomerMobility;
use App\Models\Customer\CustomerMobilityCheque;
use App\Models\Customer\CustomerMobilityPrlv;
use App\Models\Customer\CustomerMobilityVirIncoming;
use App\Models\Customer\CustomerMobilityVirOutgoing;
use App\Models\Customer\CustomerTransfer;
use Faker\Factory;
use Illuminate\Http\Request;

class MobilityController extends Controller
{
    public function showDocument($mobility_id)
    {
        $mobility = CustomerMobility::find($mobility_id);

        return view('customer.subscription.document', compact('mobility'));
    }

    public function signateDocument(Request $request, $mobility_id)
    {
        $faker = Factory::create('fr_FR');
        switch ($request->get('type')) {
            case 'prlv':
                try {
                    $prlv = CustomerMobilityPrlv::find($request->get("id"));
                    $p = $prlv->mobility->wallet->sepas()->create([
                        'uuid' => $prlv->uuid,
                        'creditor' => $prlv->creditor,
                        'number_mandate' => $prlv->number_mandate,
                        'amount' => $prlv->amount,
                        'status' => 'waiting',
                        'customer_wallet_id' => $prlv->mobility->wallet->id
                    ]);
                    $search_creditor = CustomerCreditor::where('name', '%' . $p->creditor . '%')->count();
                    if ($search_creditor == 0) {
                        $p->creditor()->create(["name" => $p->creditor, "customer_wallet_id" => $p->wallet->id, "customer_sepa_id" => $p->id]);
                    }
                    $prlv->validate();
                    return response()->json();
                } catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json(['errors' => [$exception->getMessage()]], 500);
                }
            case 'incoming':
                try {
                    $incoming = CustomerMobilityVirIncoming::find($request->get('id'));

                    $type_bene = $faker->boolean();
                    $bank = Bank::all()->random();

                    $beneficiaire = $incoming->mobility->customer->beneficiaires()->create([
                        'uuid' => \Str::uuid(),
                        "type" => $type_bene ? "retail" : "corporate",
                        "company" => !$type_bene ? $faker->company : null,
                        "firstname" => $type_bene ? $faker->firstName : null,
                        "lastname" => $type_bene ? $faker->lastName : null,
                        "bankname" => $bank->name,
                        "iban" => $faker->iban("FR"),
                        "bic" => $faker->swiftBicNumber,
                        "titulaire" => false,
                        "customer_id" => $incoming->mobility->customer->id,
                        "bank_id" => $bank->id
                    ]);

                    $i = $incoming->mobility->wallet->transfers()->create([
                        "uuid" => $incoming->uuid,
                        "amount" => $incoming->amount,
                        "reference" => $incoming->reference,
                        "reason" => $incoming->reason,
                        "type" => $incoming->type,
                        "transfer_date" => $incoming->transfer_date,
                        "recurring_start" => $incoming->recurring_start,
                        "recurring_end" => $incoming->recurring_end,
                        "customer_wallet_id" => $incoming->mobility->wallet->id,
                        "customer_beneficiaire_id" => $beneficiaire->id
                    ]);


                    if ($i->type == 'immediat') {
                        CustomerTransferHelper::executeTransfer($i->id);
                    } elseif($i->type == 'differed') {
                        CustomerTransferHelper::initTransfer($i->id);
                    } else {
                        CustomerTransferHelper::programTransfer($i->id);
                    }

                    $incoming->validate();

                    return response()->json();

                } catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json(["errors" => [$exception->getMessage()]], 500);
                }
            case 'outgoing':
                try {
                    $outgoing = CustomerMobilityVirOutgoing::find($request->get('id'));

                    $type_bene = $faker->boolean();
                    $bank = Bank::all()->random();

                    $beneficiaire = $outgoing->mobility->customer->beneficiaires()->create([
                        'uuid' => \Str::uuid(),
                        "type" => $type_bene ? "retail" : "corporate",
                        "company" => !$type_bene ? $faker->company : null,
                        "firstname" => $type_bene ? $faker->firstName : null,
                        "lastname" => $type_bene ? $faker->lastName : null,
                        "bankname" => $bank->name,
                        "iban" => $faker->iban("FR"),
                        "bic" => $faker->swiftBicNumber,
                        "titulaire" => false,
                        "customer_id" => $outgoing->mobility->customer->id,
                        "bank_id" => $bank->id
                    ]);

                    $i = $outgoing->mobility->wallet->transfers()->create([
                        "uuid" => $outgoing->uuid,
                        "amount" => $outgoing->amount,
                        "reference" => $outgoing->reference,
                        "reason" => $outgoing->reason,
                        "type" => $outgoing->transfer_date->startOfDay() == now()->startOfDay() ? "immediat" : "differed",
                        "transfer_date" => $outgoing->transfer_date,
                        "recurring_start" => null,
                        "recurring_end" => null,
                        "customer_wallet_id" => $outgoing->mobility->wallet->id,
                        "customer_beneficiaire_id" => $beneficiaire->id
                    ]);


                    if ($i->type == 'immediat') {
                        CustomerTransferHelper::executeTransfer($i->id);
                    } elseif($i->type == 'differed') {
                        CustomerTransferHelper::initTransfer($i->id);
                    } else {
                        CustomerTransferHelper::programTransfer($i->id);
                    }

                    $outgoing->validate();

                    return response()->json();

                } catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json(["errors" => [$exception->getMessage()]], 500);
                }
            case 'cheque':
                try {
                    $cheque = CustomerMobilityCheque::find($request->get('id'));

                    CustomerTransactionHelper::create(
                        'debit',
                        'payment',
                        "Paiement par chèque",
                        $cheque->amount,
                        $cheque->mobility->wallet->id,
                        $cheque->date_enc <= now() ? 1 : 0,
                        "Chèque N°".$cheque->number,
                        $cheque->date_enc <= now() ? $cheque->date_enc : now(),
                        $cheque->date_enc <= now() ? $cheque->date_enc : now(),
                    );

                    $cheque->validate();


                    return response()->json();

                } catch (\Exception $exception) {
                    LogHelper::notify('critical', $exception);
                    return response()->json(["errors" => [$exception->getMessage()]], 500);
                }

            case 'allPrlv':
                $mobility = CustomerMobility::find($mobility_id);

                foreach ($mobility->prlvs()->where('valid', 0)->get() as $prlv) {
                    $p = $prlv->mobility->wallet->sepas()->create([
                        'uuid' => $prlv->uuid,
                        'creditor' => $prlv->creditor,
                        'number_mandate' => $prlv->number_mandate,
                        'amount' => $prlv->amount,
                        'status' => 'waiting',
                        'customer_wallet_id' => $prlv->mobility->wallet->id
                    ]);
                    $search_creditor = CustomerCreditor::where('name', '%' . $p->creditor . '%')->count();
                    if ($search_creditor == 0) {
                        $p->creditor()->create(["name" => $p->creditor, "customer_wallet_id" => $p->wallet->id, "customer_sepa_id" => $p->id]);
                    }
                    $prlv->validate();
                }
                return response()->json();
            case 'allIncoming':
                $mobility = CustomerMobility::find($mobility_id);

                foreach ($mobility->incomings()->where('valid', 0)->get() as $incoming) {
                    $type_bene = $faker->boolean();
                    $bank = Bank::all()->random();

                    $beneficiaire = $incoming->mobility->customer->beneficiaires()->create([
                        'uuid' => \Str::uuid(),
                        "type" => $type_bene ? "retail" : "corporate",
                        "company" => !$type_bene ? $faker->company : null,
                        "firstname" => $type_bene ? $faker->firstName : null,
                        "lastname" => $type_bene ? $faker->lastName : null,
                        "bankname" => $bank->name,
                        "iban" => $faker->iban("FR"),
                        "bic" => $faker->swiftBicNumber,
                        "titulaire" => false,
                        "customer_id" => $incoming->mobility->customer->id,
                        "bank_id" => $bank->id
                    ]);

                    $i = $incoming->mobility->wallet->transfers()->create([
                        "uuid" => $incoming->uuid,
                        "amount" => $incoming->amount,
                        "reference" => $incoming->reference,
                        "reason" => $incoming->reason,
                        "type" => $incoming->type,
                        "transfer_date" => $incoming->transfer_date,
                        "recurring_start" => $incoming->recurring_start,
                        "recurring_end" => $incoming->recurring_end,
                        "customer_wallet_id" => $incoming->mobility->wallet->id,
                        "customer_beneficiaire_id" => $beneficiaire->id
                    ]);


                    if ($i->type == 'immediat') {
                        CustomerTransferHelper::executeTransfer($i->id);
                    } elseif($i->type == 'differed') {
                        CustomerTransferHelper::initTransfer($i->id);
                    } else {
                        CustomerTransferHelper::programTransfer($i->id);
                    }

                    $incoming->validate();
                }

                return response()->json();
            case 'allOutgoing':
                $mobility = CustomerMobility::find($mobility_id);

                foreach ($mobility->outgoings()->where('valid', 0)->get() as $outgoing) {
                    $type_bene = $faker->boolean();
                    $bank = Bank::all()->random();

                    $beneficiaire = $outgoing->mobility->customer->beneficiaires()->create([
                        'uuid' => \Str::uuid(),
                        "type" => $type_bene ? "retail" : "corporate",
                        "company" => !$type_bene ? $faker->company : null,
                        "firstname" => $type_bene ? $faker->firstName : null,
                        "lastname" => $type_bene ? $faker->lastName : null,
                        "bankname" => $bank->name,
                        "iban" => $faker->iban("FR"),
                        "bic" => $faker->swiftBicNumber,
                        "titulaire" => false,
                        "customer_id" => $outgoing->mobility->customer->id,
                        "bank_id" => $bank->id
                    ]);

                    $i = $outgoing->mobility->wallet->transfers()->create([
                        "uuid" => $outgoing->uuid,
                        "amount" => $outgoing->amount,
                        "reference" => $outgoing->reference,
                        "reason" => $outgoing->reason,
                        "type" => $outgoing->transfer_date->startOfDay() == now()->startOfDay() ? "immediat" : "differed",
                        "transfer_date" => $outgoing->transfer_date,
                        "recurring_start" => null,
                        "recurring_end" => null,
                        "customer_wallet_id" => $outgoing->mobility->wallet->id,
                        "customer_beneficiaire_id" => $beneficiaire->id
                    ]);


                    if ($i->type == 'immediat') {
                        CustomerTransferHelper::executeTransfer($i->id);
                    } elseif($i->type == 'differed') {
                        CustomerTransferHelper::initTransfer($i->id);
                    } else {
                        CustomerTransferHelper::programTransfer($i->id);
                    }

                    $outgoing->validate();
                }

                return response()->json();
            case 'allCheque':
                $mobility = CustomerMobility::find($mobility_id);

                foreach ($mobility->cheques()->where('valid', 0)->get() as $cheque) {
                    CustomerTransactionHelper::create(
                        'debit',
                        'payment',
                        "Paiement par chèque",
                        $cheque->amount,
                        $cheque->mobility->wallet->id,
                        $cheque->date_enc <= now() ? 1 : 0,
                        "Chèque N°".$cheque->number,
                        $cheque->date_enc <= now() ? $cheque->date_enc : now(),
                        $cheque->date_enc <= now() ? $cheque->date_enc : now(),
                    );

                    $cheque->validate();
                }

                return response()->json();

        }
    }
}
