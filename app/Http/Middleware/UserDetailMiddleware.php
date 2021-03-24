<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        $role = Auth::user()->role->name;
        if(!Auth::user()->person_id){
            return redirect('user/personal-details/'.$role);
        }else{
            $person = Person::where('id', Auth::user()->person_id)->first();
            if(!$person->isCompleteDetail){
                return redirect('user/personal-details/'.$role);
            }
        }

        return $next($request);
    }
}
