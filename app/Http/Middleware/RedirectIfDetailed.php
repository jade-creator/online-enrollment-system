<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfDetailed
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

        $person = Person::select('isCompleteDetail')->where('id', Auth::user()->person_id)->first();

        if(Auth::user()->person_id && $person->isCompleteDetail){
            return redirect()->route('user.personal.profile.view', Auth::user()->id);
        }

        return $next($request);
    }
}
