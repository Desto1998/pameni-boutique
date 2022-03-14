<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Pays;
use App\Models\Produits;
use http\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ClientController extends Controller
{
    //List all clients
    public function index(){
        $data = Clients::orderBy('date_ajout','desc')->get();
        $pays = Pays::all();
        return view('client.index',compact('data','pays'));
    }
    public function loadClients(){
        if (request()->ajax()) {

            $data = Clients::leftJoin('pays','pays.pays_id','clients.idpays')
            ->join('users', 'users.id', 'clients.iduser')->orderBy('clients.date_ajout','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = view('client.action',compact('row'));

//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                    return (string)$action;
                })
                ->addColumn('nom', function($row){
                    $nom = $row->nom_client.' '.$row->prenom_client.' '.$row->raison_s_client;
                    return $nom;
                })

                ->addColumn('phone', function($row){
                    $phone = $row->phone_1_client.' / '.$row->phone_2_client;
                    return $phone;
                })
                ->rawColumns(['action','nom','phone'])
                ->make(true);

        }
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

        if ($request->type_client==0) {
            $request->validate([
                'nom_client'=>['required']
            ]);
            $nom=$request->nom_client;
            $prenom = $request->prenom_client;
        }else{
            $request->validate([
                'raison_s_client'=>['required']
            ]);
            $rcm = $request->rcm;
            $contribuabe = $request->contribuabe;
            $raison = $request->raison_s_client;
        }
        $iduser = Auth::user()->id;
        $dataId = $request->client_id;
        $date=date('Y-m-d');
        if ($dataId) {
            $date = $request->date_ajout;
        }
        $save  = Clients::updateOrCreate(
            ['client_id' => $dataId],
            [
                'nom_client' => $nom,
                'prenom_client' => $prenom,
                'raison_s_client' => $raison,
                'phone_1_client' => $request->phone_1,
                'phone_2_client' => $request->phone_2,
                'email_client' => $request->email_client,
                'contribuable' => $contribuabe,
                'rcm' => $rcm,
                'idpays' => $request->idpays,
                'iduser' => $iduser,
                'ville_client' => $request->ville_client,
                'adresse_client' => $request->adresse_client,
                'postale' => $request->postale,
                'type_client' => $request->type_client,
                'date_ajout' => $date,

            ])
        ;
        return Response()->json($save);
//        if ($save) {
//            return redirect()->route('client.all')->with('success','Enregistré avec succès!');
//
//        }
//        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }
//    update client
    public function update(Request $request){
        $request->validate([
            'phone_1'=>['required']
        ]);
        $nom = '';
        $raison = '';
        $prenom = '';
        $rcm = '';
        $contribuabe = '';

        if ($request->type_client==0) {
            $request->validate([
                'nom_client'=>['required']
            ]);
            $nom=$request->nom_client;
            $prenom = $request->prenom_client;
        }else{
            $request->validate([
                'raison_s_client'=>['required']
            ]);
            $rcm = $request->rcm;
            $contribuabe = $request->contribuabe;
            $raison = $request->raison_s_client;
        }
        $iduser = Auth::user()->id;
        $dataId = $request->client_id;
        $date=date('Y-m-d');
        if ($dataId) {
            $date = $request->date_ajout;
        }
        $save  = Clients::updateOrCreate(
            ['client_id' => $dataId],
            [
                'nom_client' => $nom,
                'prenom_client' => $prenom,
                'raison_s_client' => $raison,
                'phone_1_client' => $request->phone_1,
                'phone_2_client' => $request->phone_2,
                'email_client' => $request->email_client,
                'contribuable' => $contribuabe,
                'rcm' => $rcm,
                'idpays' => $request->idpays,
                'iduser' => $iduser,
                'ville_client' => $request->ville_client,
                'adresse_client' => $request->adresse_client,
                'postale' => $request->postale,
                'type_client' => $request->type_client,
                'date_ajout' => $date,

            ])
        ;
//        return Response()->json($save);
        if ($save) {
            return redirect()->route('client.all')->with('success','Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }
    public function showEditForm($id){
        $client = Clients::find($id);
        $pays = Pays::all();
        return view('client.edit',compact('client','pays'));
    }
    public function delete(Request $request){
        $delete = Clients::where('client_id',$request->id)->delete();
        return Response()->json($delete);
    }

    public function view($id){
        $client = Clients::find($id);
        return view('client.detail',compact('client'));
    }

}
