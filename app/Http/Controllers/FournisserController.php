<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Commandes;
use App\Models\Fournisseurs;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FournisserController extends Controller
{
    //
    //List all clients
    public function index()
    {
//        $data = Fournisseurs::all();
        $pays = Pays::orderBy('nom_pays','asc')->get();
        return view('fournisseur.index', compact('pays'));
    }

    public function loadFournisseur()
    {
        if (request()->ajax()) {
            $data = Fournisseurs::leftJoin('pays', 'pays.pays_id', 'fournisseurs.idpays')
                ->Join('users', 'users.id', 'fournisseurs.iduser')
                ->orderBy('fournisseurs.date_ajout_fr', 'desc')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
//                ->addColumn('action', function($row){
//                    $action = view('client.action',compact('row'));
//
////                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
//                    return (string)$action;
//                })
                ->addColumn('action', function ($row) {
                    $action = view('fournisseur.action', compact('row'));
                    return (string)$action;
                })
                ->addColumn('nom', function ($row) {
                    $nom = $row->nom_fr . ' ' . $row->prenom_fr . ' ' . $row->raison_s_fr;
                    return $nom;
                })
                ->addColumn('phone', function ($row) {
                    $phone = $row->phone_1_fr . ' / ' . $row->phone_2_fr;
                    return $phone;
                })
                ->rawColumns(['action', 'nom', 'phone'])
                ->make(true);

        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone_1' => ['required']
        ]);
        $nom = '';
        $raison = '';
        $prenom = '';
        $rcm = '';
        $contribuabe = '';

        if ($request->type_fr == 0) {
            $request->validate([
                'nom_fr' => ['required']
            ]);
            $nom = $request->nom_fr;
            $prenom = $request->prenom_fr;
        } else {
            $request->validate([
                'raison_s_fr' => ['required']
            ]);
            $rcm = $request->rcm;
            $contribuabe = $request->contribuabe;
            $raison = $request->raison_s_fr;
        }
        $iduser = Auth::user()->id;
        $dataId = $request->fournisseur_id;
        $date = date('Y-m-d');
        if ($dataId) {
            $date = $request->date_ajout;
        }
        $save = Fournisseurs::updateOrCreate(
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

            ]);
        return Response()->json($save);
//        if ($save) {
//            return redirect()->route('fournisseur.all')->with('success','Enregistré avec succès!');
//
//        }
//        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone_1' => ['required']
        ]);
        $nom = '';
        $raison = '';
        $prenom = '';
        $rcm = '';
        $contribuabe = '';

        if ($request->type_fr == 0) {
            $request->validate([
                'nom_fr' => ['required']
            ]);
            $nom = $request->nom_fr;
            $prenom = $request->prenom_fr;
        } else {
            $request->validate([
                'raison_s_fr' => ['required']
            ]);
            $rcm = $request->rcm;
            $contribuabe = $request->contribuabe;
            $raison = $request->raison_s_fr;
        }
        $iduser = Auth::user()->id;
        $dataId = $request->fournisseur_id;
        $date = date('Y-m-d');
        if ($dataId) {
            $date = $request->date_ajout;
        }
        $save = Fournisseurs::updateOrCreate(
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

            ]);
//        return Response()->json($save);
        if ($save) {
            return redirect()->route('fournisseur.all')->with('success', 'Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function showEditForm($id)
    {
        $fournisseur = Fournisseurs::find($id);
        $pays = Pays::all();
        return view('fournisseur.edit', compact('fournisseur', 'pays'));
    }

    public function delete(Request $request)
    {
        Commandes::where('idfournisseur',$request->id)->delete();
        $delete = Fournisseurs::where('fournisseur_id', $request->id)->delete();
        return Response()->json($delete);
    }

    public function view($id)
    {
        $data = Fournisseurs::leftJoin('pays', 'pays.pays_id', 'fournisseurs.idpays')
            ->join('users', 'users.id', 'fournisseurs.iduser')
            ->where('fournisseurs.fournisseur_id', $id)
            ->get();
        return view('fournisseur.detail', compact('data'));


    }
}
