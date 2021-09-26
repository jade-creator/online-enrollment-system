<?php

namespace App\Http\Middleware;

use App\Traits\WithSweetAlert;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfApproved
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
        if(! Auth::check()) return redirect('/login');

        if (is_null(auth()->user()->approved_at)) {
            return redirect()->route('user.personal.profile.view', auth()->user()->id)->with('swal:modal', [
                'title' => $this->infoTitle,
                'type' => $this->infoType,
                'text' => 'ACCOUNT PENDING: Your account is currently not active. An administrator needs to activate your account before you can proceed.',
            ]);
        }

        return $next($request);
    }
}
