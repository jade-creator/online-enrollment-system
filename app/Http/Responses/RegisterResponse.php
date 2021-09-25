<?php

namespace App\Http\Responses;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Response;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $home = (new LoginResponse())->redirectUrl(auth()->user()->role->name);

        return $request->wantsJson()
            ? new Response('', 201)
            : redirect($home);
    }
}
