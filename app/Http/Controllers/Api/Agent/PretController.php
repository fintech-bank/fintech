<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Models\Core\LoanPlan;
use Illuminate\Http\Request;

class PretController extends Controller
{
    public function info($plan_id)
    {
        return response()->json(LoanPlan::with('interests')->find($plan_id));
    }
}
