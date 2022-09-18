<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWithdraw;
use App\Models\Customer\CustomerWithdrawDab;
use Illuminate\Http\Request;

class CustomerWithdrawController extends Controller
{
    public function index(Request $request)
    {
        $pdvs = CustomerWithdrawDab::all();
        $withdraws = CustomerWithdraw::all();

        return view('agent.withdraw.index', compact('pdvs', 'withdraws'));
    }
}
