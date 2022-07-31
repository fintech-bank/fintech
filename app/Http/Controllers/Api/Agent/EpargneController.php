<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Models\Core\EpargnePlan;

class EpargneController extends Controller
{
    public function info($plan_id)
    {
        $epargne = EpargnePlan::query()->find($plan_id);

        return response()->json($epargne);
    }
}
