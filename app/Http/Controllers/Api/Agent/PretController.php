<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helper\CustomerLoanHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\LoanPlan;
use Illuminate\Http\Request;

class PretController extends Controller
{
    public function info($plan_id)
    {
        return response()->json(LoanPlan::with('interests')->find($plan_id));
    }

    public function simulate(Request $request)
    {
        $plan = LoanPlan::query()->find($request->get('loan_plan_id'));
        if($request->get('duration') > $plan->duration) {
            return response()->json(["errors" => [
                "Durée Non autorisé" =>"La durée du pret est supérieur à la limite autorisé !"
            ]], 500);
        }

        if($request->get('amount') < $plan->minimum) {
            return response()->json(["errors" => [
                "Montant non autorisé" =>"Le montant ne peut être inférieur à ".eur($plan->minimum)
            ]], 500);
        }

        if($request->get('amount') > $plan->maximum) {
            return response()->json(["errors" => [
                "Montant non autorisé" =>"Le montant ne peut être supérieur à ".eur($plan->maximum)
            ]], 500);
        }

        $arr = [
            'amount_loan' => eur($request->get('amount')),
            'duration' => $request->get('duration'),
            'mensuality' => eur(CustomerLoanHelper::calcMensuality($request->get('amount'), $request->get('duration'), $plan, 'DIM')),
            'interest' => eur(CustomerLoanHelper::getLoanInterest($request->get('amount'), $plan->interests[0]->interest)),
            'amount_du' => eur($request->get('amount') + CustomerLoanHelper::getLoanInterest($request->get('amount'), $plan->interests[0]->interest)),
            'insurance_du' => eur(CustomerLoanHelper::getLoanInsurance('DIM') * $request->get('duration')),
            'insurance_mensuality' => eur(CustomerLoanHelper::getLoanInsurance('DIM'))
        ];

        return response()->json($arr);
    }
}
