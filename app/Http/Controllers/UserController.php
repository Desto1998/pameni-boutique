<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    protected function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }


    protected function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:14', 'min:8'],
            'role' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $checkemail = User::where('email', $request->email)->get();
        if (count($checkemail) > 0) {
            return redirect()->back()->with('warning', 'Cette adresse E-mail est déja utilisé par un autre.');
        }
        $role = 0;
        if ($request->role == 1) {
            $role = 1;
        }
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_admin' => $role,
            'is_active' => 1,
            'idrole' => $request->role,
            'password' => Hash::make($request->password),

        ]);
        if ($user) {
            return redirect(route('user.all'))->with('success', 'L\'utilisateur a été créé avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }


    protected function editUser($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }
//
//    public function doUser()
//    {
//        $do = (new User)::setUser();
//        if ($do) {
//            return "Done...";
//        } else {
//            return "Failed";
//        }
//    }
//
//    public function redoUser()
//    {
////        DB::table('table')->update(['column' => 1]);
//        $do = (new User)::resetUser();
//        if ($do) {
//            return "Done...";
//        } else {
//            return "Failed";
//        }
//    }

    protected function updateUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:14', 'min:8'],
            'role' => ['required'],
            'userid' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'oldpassword' => ['string', 'min:6'],
        ]);
        $checkemail = User::where('email', $request->email)->where('id', '!=', $request->userid)->get();
        if (count($checkemail) > 0) {
            return redirect()->back()->with('warning', 'Cette adresse E-mail est déja utilisé par un autre.');
        }
        $current_user_password = Auth::user()->password;
        if (empty($request->oldpassword) || Hash::check($request->oldpassword, $current_user_password) == true) {
            $role = 0;
            if ($request->role == 1) {
                $role = 1;
            }
            $user = User::where('id', $request->userid)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'is_admin' => $role,
                'is_active' => 1,
                'idrole' => $request->role,
                'password' => Hash::make($request->password),

            ]);
        } else {
            session()->flash('message', 'Ancien mot de passe incorrect!');
            return redirect()->back()->with('error', 'Ancien mot de passe incorrect!');
        }


        if ($user) {
            return redirect(route('user.all'))->with('success', 'Modifications enregistrées avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }

    protected function showProfile()
    {
        $id  = Auth::user()->id;
        $user = User::find($id);
        return view('user.profile', compact('user'));
    }
    protected function updateInfos(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:14', 'min:8'],
            'userid' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        $checkemail = User::where('email', $request->email)->where('id', '!=', $request->userid)->get();
        if (count($checkemail) > 0) {
            return redirect()->back()->with('warning', 'Cette adresse E-mail est déja utilisé par un autre.');
        }

        $user = User::where('id', $request->userid)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);


        if ($user) {
            return redirect(route('user.profile'))->with('success', 'Modifications enregistrées avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'oldpassword' => ['string', 'min:6'],
        ]);
        $current_user_password = Auth::user()->password;
        if (empty($request->oldpassword) || Hash::check($request->oldpassword, $current_user_password) == true) {
            $user = User::where('id', $request->userid)->update([
                'password' => Hash::make($request->password),
            ]);
        } else {
            session()->flash('message', 'Ancien mot de passe incorrect!');
            return redirect()->back()->with('error', 'Ancien mot de passe incorrect!');
        }
        if ($user) {
            return redirect(route('user.profile'))->with('success', 'Modifications enregistrées avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    protected function deleteUser(Request $request)
    {
//        $identreprise = Auth::user()->identreprise;
        $delete = User::where('id', $request->id)->delete();
        return Response()->json($delete);
    }
    public function UpdateImage(Request $request){
//        $input =1;
//        $code = str_pad($input, 4, "0", STR_PAD_LEFT);
//        dd($code);
        $file = $request->file('logo');

        $request->validate([
            'logo.*' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $destinationPath = 'images/profil';
        $originalFile = $file->getClientOriginalName();
        $file->move($destinationPath, $originalFile);

        $save = User::where('id',$request->userid)->update([
            'profile_photo_path' => $originalFile,
        ]);
        if ($save) {
            return redirect()->back()->with('success','Enregistré avec succès!');
        }else{
            return redirect()->back()->with('danger',"Désolé une erreur s'est produit! Veillez reéssayer.");
        }
    }


    public function activate($id)
    {
        $data = "";
        $data = User::where('id', $id)->update(['is_active' => 1]);
//        return Response()->json($data);
        return redirect()->back()->with('success','Le compte a été activé avec succès!');

    }


    public function block($id)
    {
        $data = "";
        $data = User::where('id', $id)->update(['is_active' => 0]);
//        return Response()->json($data);
        return redirect()->back()->with('success','Le compte a été bloqué avec succès!');

    }

}
