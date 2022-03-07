<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Fournisseurs;
use App\Models\Pays;
use Illuminate\Http\Request;

class FournisserController extends Controller
{
    //
    //List all clients
    public function index(){
        $data = Fournisseurs::all();
        $pays = Pays::all();
        return view('fournisseur.index',compact('data','pays'));
    }

    public function store(Request $request){
        return "In process";
    }

    public function delete(Request $request){
        $delete = Fournisseurs::where('fournisseur_id',$request->id)->delete();
        return Response()->json($delete);
    }

    public function view($id){
        $fournisseur = Fournisseurs::find($id);
        return view('fournisseur.detail',compact('fournisseur'));
    }
}
