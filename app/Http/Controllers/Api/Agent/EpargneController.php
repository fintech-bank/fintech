<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Models\Core\EpargnePlan;
use Illuminate\Http\Request;

class EpargneController extends Controller
{
    public function info($plan_id)
    {
        $epargne = EpargnePlan::query()->find($plan_id);

        return response()->json($epargne);
    }
}
