<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetPasswordLink(Request $request)
    {
        $request ->validate([
            'email' => 'required|email'
        ]);
//        $token = str_random(64);
        $token = Str::random(60);
//        dd($token);
        $date = date('Y-m-d H:m:s');
//        dd($date);
        $checkemail = User::where('email',$request->email)->get();
        if (count($checkemail)<1) {
            return  redirect()->back()->with('danger',"Adresse email introuvable!");
        }
        $save = DB::insert('insert into password_resets(email, token,created_at) values (?, ?,?)', [$request->email, $token, $date]);

        if ($save) {
            $message = "<h2>GSC-APP</h2><br><h4>Récupération de compte</h4><br><br><form method='get' action=''>
                        <input type='hidden' name='email' value='$request->email'>
                        <input type='hidden' name='token' value='$request->token'>
                        <input type='hidden' name='date' value='$date'>
                        <a href='http://gsc-app.test/resetPassword/infos/$token/$request->email/$date' style='text-decoration: none;border-color: #3a34f6;background-color: #4540f7;color: #fff; display: inline-block;
                        font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;user-select: none;
                        padding: 0.375rem 0.75rem;font-size: 0.875rem;line-height: 1.5;border-radius: 0.25rem;
                        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;'>
                                Changer de mot de passe
                        </a>
                </form>";
            $sendmessage = (new EmailController)->sendEmail($request->email,$request->email,$message);
            if ($sendmessage==1) {
                return redirect()->back()->with('success',"Vérifier votre compte email; un message contenant le lien de réinitialisation vous a été envoyé. \n Verifier vos span ou promotion si vous ne voyez pas dans la boite de reception.");
            }else{
                return redirect()->back()->with('danger',"Echec. Veillez vérifier si votre adresse email est valide!");

            }
        }
        return redirect()->back()->with('danger',"Une erreur s'est produit! Réessayez plus tard.");
    }
    public function ResetPasswordInfo($token, $email, $date)
    {
        $date2 = date('Y-m-d H:m:s');
//        dd($date);
        $start  = new Carbon($date);
        $end    = new Carbon($date2);
        $currentTime = $start->diff($end)->format('%H:%I:%S');
        $is_validToken = 1;
        $currentTime = "0000-00-00 ".$currentTime;
        $currentTime = strtotime($currentTime);
//        dd(date('H', $currentTime));
        if (((int) date('H', $currentTime)) >= 1) {
            $is_validToken = 0;
        }


        return view('auth.passwords.reset', compact('email','is_validToken','token'));
    }
    public function ResetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'max:255', 'email'],
            'token' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $checkToken = DB::table('password_resets')->where('token', '=',$request->token)
            ->where('email', '=',$request->email)->get();
        if (count($checkToken)<1) {
            return redirect()->back()->with('danger',"Lien de validation non valide!");
        }
        $user = User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            return redirect()->back()->with('success','Mot de passe modifier avec succés!');
        }
        return redirect()->back()->with('danger',"Lien de validation non correct!");


    }
}
