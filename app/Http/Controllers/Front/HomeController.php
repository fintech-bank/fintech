<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Jenssegers\Agent\Facades\Agent;

class HomeController extends Controller
{
    public function index()
    {
        \Cache::clear();
        if(!\Cache::has('version_view')) {
            \Cache::put('version_view', ['view' => false, "latest_version" => getLatestVersion()]);
        }
        if(Agent::isMobile() || Agent::isPhone()) {
            return redirect()->to(config('domain.mobile'));
        } else {
            return view('front.index');
        }
    }

    public function redirect()
    {
        if (auth()->user()->admin == 1) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->agent == 1) {
            return redirect()->route('agent.dashboard');
        } elseif(auth()->user()->reseller == 1) {
            return redirect()->route('reseller.dashboard');
        } else {
            if (auth()->user()->customers->status_open_account == 'terminated') {
                return redirect()->route('customer.dashboard');
            } else {
                session()->put(['user' => auth()->user()]);

                return redirect()->route('register.terminate');
            }
        }
    }
}
