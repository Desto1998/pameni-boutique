<?php

namespace App\Http\Controllers;

use App\Models\User_menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    //store user menus
    public function storeMenu(Request $request){
        $request->validate([
            'idmenu',
            'userid'
        ]);
        $iduser = Auth::user()->id;
        // on supprime tous les elements du menu de l'utilisateur puis on remet
        User_menus::where('userid',$request->userid)->delete();
        for ($i=0; $i<count($request->idmenu);$i++){
            $save[$i] = User_menus::create([
                'iduser'=>$iduser,
                'idmenu'=>$request->idmenu[$i],
                'userid'=>$request->userid,
            ]);
        }
        if ($save) {
            return redirect(route('user.all'))->with('success', 'Enregistrées avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");


    }
}
