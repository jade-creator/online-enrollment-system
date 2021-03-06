<?php

namespace App\Http\Middleware;

use App\Traits\WithSweetAlert;
use Closure;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetailMiddleware
{
    use WithSweetAlert;
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

        $role = Auth::user()->role->name == 'student' ? 'student' : 'employee';

        if (! Auth::user()->person_id) {
            return redirect('user/personal-details/'.$role)->with('swal:modal', [
                'title' => $this->infoTitle,
                'type' => $this->infoType,
                'text' => 'Welcome, Please fill out required information. Thank you!',
            ]);
        }

        // $person = Person::select('isCompleteDetail')->where('id', Auth::user()->person_id)->first();
        $isCompleteDetail = Auth::user()->person->isCompleteDetail;

        if(! $isCompleteDetail){
            return redirect('user/personal-details/'.$role)->with('swal:modal', [
                'title' => $this->infoTitle,
                'type' => $this->infoType,
                'text' => 'Please complete the process. Thank you!',
            ]);
        }

        return $next($request);
    }
}
