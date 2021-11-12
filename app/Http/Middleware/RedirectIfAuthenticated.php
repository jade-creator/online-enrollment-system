<?php

namespace App\Http\Middleware;

use App\Http\Responses\LoginResponse;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $home = (new LoginResponse())->redirectUrl(auth()->user()->role->name);

                return $request->wantsJson()
                    ? new Response('', 201)
                    : redirect($home);

//                $role = Auth::user()->role->name;
//
//                switch ($role) {
//                    case 'admin':
//                        return redirect('/admin/dashboard');
//                        break;
//
//                    case 'student':
//                        return redirect('/student/pre-registrations');
//                        break;
//
//                    default:
//                        return redirect(RouteServiceProvider::HOME);
//                        break;
//                }
            }
        }

        return $next($request);
    }
}
