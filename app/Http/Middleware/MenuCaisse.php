<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MenuCaisse
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
        if (!in_array('GCA',\App\Models\User_menus::getUserMenu())) {
            return redirect()->back()->with('danger','Désolé vous ne pouvez pas accèder à ce menu.');
        }
        return $next($request);
    }
}
