<?php

namespace App\Http\Controllers;

use App\Models\Charges;
use App\Models\Clients;
use App\Models\Commandes;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Fournisseurs;
use App\Models\Produit_Factures;
use App\Models\Produits;
use App\Models\Taches;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = Clients::all();
        $fournisseurs = Fournisseurs::all();
        $devis = Devis::all();
        $factures =Factures::all();
        $commandes= Commandes::all();
        $devisNV = Devis::where('statut',0)->get();
        $commandesNV = Commandes::where('statut',0)->get();
        $factureNV = Factures::where('statut',0)->get();
        $devisSF = Devis::whereYear('created_at', date('Y'))
            ->whereRaw('devis_id in (select iddevis from factures)')
            ->get();
        $date = date('Y-m-d H:m:s');
        $date = new DateTime($date);
        $date->sub(new DateInterval("P1D"));
//                dd($date);
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        $produit = Produits::all();
        $proFact= Produit_Factures::all();
        $prodID = [];
//        foreach ($proFact as $key => $item){
//            if (!in_array($item->idproduit)) {
//
//            }
//        }
        $charges = Charges::all();
        $taches = Taches::all();
        $lastactivity = Devis::join('users','users.id','devis.iduser')->where('devis.created_at','>=',$date)->orderBy('devis.created_at','desc')->get();
        $lastactivity1 = Factures::join('users','users.id','factures.iduser')->where('factures.created_at','>=',$date)->orderBy('factures.created_at','desc')->get();
        $lastactivity2 = Commandes::join('users','users.id','commandes.iduser')->where('commandes.created_at','>=',$date)->orderBy('commandes.created_at','desc')->get();
        return view('dashboard',compact('clients','fournisseurs','devisNV',
        'commandesNV','factureNV','devisSF','lastactivity','lastactivity1','lastactivity2','charges','taches'));
    }

    public function text()
    {
        return redirect(route('home'))->with('warning','Un bon test reuissi toujours!');
    }

}
