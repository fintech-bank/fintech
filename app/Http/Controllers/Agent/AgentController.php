<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    public function dashboard()
    {
        return view('agent.dashboard');
    }
}
