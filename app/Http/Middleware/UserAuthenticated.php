<?php

namespace App\Http\Middleware;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Auth;


class UserAuthenticated
{
    protected $guard = 'users';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard($this->guard)->check()) {
            return $next($request);
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unautthorized.', 401);
        } else {
            return redirect(route('login'));
        }
    }
}
