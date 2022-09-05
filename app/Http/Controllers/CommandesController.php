<?php

namespace App\Http\Controllers;

use App\Http\Resources\Produits;
use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commandes;
use App\Models\Contient;
use Illuminate\Http\Request;

class CommandesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $data = Commandes::join('clients','clients.idclient','commandes.idclient')->get();
        $produits = \App\Models\Produits::join('contient','contient.idproduit','produits.id')->get();
        return view('admin.commande.index',compact('data','produits'));
    }
    public function client()
    {
        $data = Clients::all();
        return view('admin.commande.client',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'min:3', 'string'],
            'email' => ['required'],
            'tel' => ['required'],
            'ville' => ['required'],
            'adresse' => ['required'],
//            'prix' => ['required'],
        ]);
        $client = Clients::create([
           'nom'=>$request->nom,
           'prenom'=>$request->prenom,
           'email'=>$request->email,
           'tel'=>$request->tel,
           'ville'=>$request->ville,
           'adresse'=>$request->adresse,
           'pwd'=>'dffddf',
           'date_ajout'=>date('Y-m-d'),
        ]);
        $commande = Commandes::create([
            'idclient'=>$client->idclient,
            'statut'=>0,
            'note'=>$request->note,
            'date_com'=>date('Y-m-d'),
        ]);
        for ($i=0;$i<count($request->produit);$i++)
        $contient = Contient::create([
            'qte'=>$request->qte[$i]??'',
            'idproduit'=>$request->produit[$i]??'',
            'idcommande'=>$commande->idcommande,
        ]);

        if ($client and $commande and $contient) {
            session(['panier' => null]);
            return redirect()->route('paiement')->with('success','Commande enregisttré avec succès, nous vous revenons sous peu. Merci de nous faire confiance.');

        }else{
            return redirect()->back()->with('danger','Une erreur s\'produite. Merci de recommencer!');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commandes  $commandes
     * @return \Illuminate\Http\Response
     */
    public function show(Commandes $commandes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commandes  $commandes
     * @return \Illuminate\Http\Response
     */
    public function edit(Commandes $commandes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commandes  $commandes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commandes $commandes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commandes  $commandes
     *
     */
    public function destroy(Request $request)
    {
        $delete = Commandes::where('idcommande', $request->id)->delete();
        return Response()->json($delete);
    }
    public function delete(Request $request)
    {
        $delete = Commandes::where('idcommande', $request->id)->delete();
        return Response()->json($delete);
    }
    public function encours($id){
        $encour = Commandes::where('idcommande',$id)->update(['statut'=>1]);
        return redirect()->back()->with('success','Commande effectué avec succès.');

    }
    public function traite($id){
        $encour = Commandes::where('idcommande',$id)->update(['statut'=>2]);
        return redirect()->back()->with('success','Effectué avec succès.');

    }
}
