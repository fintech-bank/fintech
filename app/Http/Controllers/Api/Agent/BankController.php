<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use App\Models\Core\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function info($id)
    {
        $bank = Bank::query()->find($id);

        return response()->json($bank);
    }
}
