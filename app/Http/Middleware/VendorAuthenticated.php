<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Vendor;
class VendorAuthenticated
{

    protected $guard = "vendors";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('vendorlogin');
    //     }
    // }
    public function handle(Request $request, Closure $next)
    { 
        if (Auth::guard($this->guard)->check()) {
            return $next($request);
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unautthorized.', 401);
        } else {
            return redirect(route('vendorLogin'));
        }
    }
}
