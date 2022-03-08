<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Fournisseurs;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'phone_1'=>['required']
        ]);
        $nom = '';
        $raison = '';
        $prenom = '';
        $rcm = '';
        $contribuabe = '';

        if ($request->type_fr==0) {
            $request->validate([
                'nom_fr'=>['required']
            ]);
            $nom=$request->nom_fr;
            $prenom = $request->prenom_fr;
        }else{
            $request->validate([
                'raison_s_fr'=>['required']
            ]);
            $rcm = $request->rcm;
            $contribuabe = $request->contribuabe;
            $raison = $request->raison_s_fr;
        }
        $iduser = Auth::user()->id;
        $dataId = $request->fournisseur_id;
        $date=date('Y-m-d');
        if ($dataId) {
            $date = $request->date_ajout;
        }
        $save  = Fournisseurs::updateOrCreate(
            ['fournisseur_id' => $dataId],
            [
                'nom_fr' => $nom,
                'prenom_fr' => $prenom,
                'raison_s_fr' => $raison,
                'phone_1_fr' => $request->phone_1,
                'phone_2_fr' => $request->phone_2,
                'email_fr' => $request->email_fr,
                'contribuable' => $contribuabe,
                'rcm' => $rcm,
                'idpays' => $request->idpays,
                'iduser' => $iduser,
                'ville_fr' => $request->ville_fr,
                'adresse_fr' => $request->adresse_fr,
                'postale' => $request->postale,
                'type_fr' => $request->type_fr,
                'date_ajout_fr' => $date,

            ])
        ;
        if ($save) {
            return redirect()->route('fournisseur.all')->with('success','Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function showEditForm($id){
        $fournisseur = Fournisseurs::find($id);
        $pays = Pays::all();
        return view('fournisseur.edit',compact('fournisseur','pays'));
    }

    public function delete(Request $request)
    {
        $delete = Fournisseurs::where('fournisseur_id', $request->id)->delete();
        return Response()->json($delete);
    }
    public function view($id){
        $fournisseur = Fournisseurs::find($id);
        return view('fournisseur.detail',compact('fournisseur'));
    }
}
