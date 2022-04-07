<?php

namespace App\Http\Controllers\Auth;
use App\Models\User_menus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request  $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me))
        {
            $user = auth()->user();
            $data = [];
            $iduser = Auth::user()->id;
            $menu = User_menus::join('menus','menus.menu_id','user_menus.idmenu')
                ->where('user_menus.userid',$iduser)
                ->select('menus.code')
                ->get()
            ;
            foreach ($menu as $key=>$item){
                $data[$key] = $item->code;
            }
            session()->regenerate();
            session(['USERMENU' => $data]);
            return back();
//            dd($user);

        }else{

            return back()->with('error','Adresse email ou mot de passe incorrect.');

        }

//    }

//        Auth::login($user);

//        return $this->authenticated($request, $user);
    }

    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
}
