<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AccountValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $is_active = Auth::user()->is_active;

            if ($is_active != 1) {
//            exit('Compte inactif');
                Auth::logout(); // log the user out of our application
                return Redirect::to('login')->with('danger','Votre  compte n\'est pas activé.'); // redirect the user to the login screen
//            return redirect('login')->with('danger','Votre  compte n\'est activé.');
            }

        return $next($request);
    }
}
