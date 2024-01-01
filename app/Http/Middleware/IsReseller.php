<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsReseller
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
        if (Auth::check() && Auth::user()->level == 'reseller' && Auth::user()->status == 'active') {
            return $next($request);
        }elseif(Auth::check() && Auth::user()->level == 'reseller'){
            return back()->with('error','akun anda belum disetujui');
        }
        else{
            return abort(403);
        }
    }
}
