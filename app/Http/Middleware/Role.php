<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, String $role)
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        $roles = is_array($role) ? $role : explode('|', $role);

        if(!in_array(Auth::user()->role->name, $roles, true)) {
            abort(403);
        }

        return $next($request);

        // $user_role = Auth::user()->role->name;
        // if($user_role == $role){
        //     return $next($request);
        // }

        // abort(403);
    }
}
