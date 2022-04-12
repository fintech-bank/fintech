<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(\Auth::check()) {
            $expire = now()->addMinutes(config('session.lifetime'));
            \Cache::put('user-is-online-'.\Auth::user()->id, true, $expire);

            User::where('id', \Auth::user()->id)->update(['last_seen' => now()]);
        }

        return $next($request);
    }
}
