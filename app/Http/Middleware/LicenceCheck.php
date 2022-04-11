<?php

namespace App\Http\Middleware;

use Closure;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenceCheck
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
        $deploy_date = '2022-04-10';
        $date = new DateTime($deploy_date);
        $nbjour = 90;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        if ($date<=date('Y-m-d')) {
            Auth::logout();
            return redirect('login')->with('danger',"Désolé votre licence a inspirée, veillez souscrire a une nouvelle licence pour pouvoir continuer à exploiter la plateforme. Merci!");
        }
        return $next($request);
    }
}
