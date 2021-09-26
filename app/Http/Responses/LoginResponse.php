<?php

namespace App\Http\Responses;

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function redirectUrl(string $role) : string
    {
        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
                break;

            case 'student':
                return '/student/pre-registrations';
                break;

            case 'faculty member':
                return '/admin/dashboard';
                break;

            default:
                return RouteServiceProvider::HOME;
                break;
        }
    }

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $home = $this->redirectUrl(auth()->user()->role->name);

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended($home);
    }
}
