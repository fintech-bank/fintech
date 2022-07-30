<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.index');
    }

    public function redirect()
    {
        if(auth()->user()->admin == 1) {
            return redirect()->route('admin.dashboard');
        } elseif(auth()->user()->agent == 1) {
            return redirect()->route('agent.dashboard');
        } else {
            if(auth()->user()->customers->status_open_account == 'terminated') {
                return redirect()->route('customer.dashboard');
            } else {
                session()->put(['user' => auth()->user()]);
                return redirect()->route('register.terminate');
            }
        }
    }
}
