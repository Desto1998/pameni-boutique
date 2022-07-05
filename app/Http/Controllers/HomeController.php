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
use Mailjet\Response;

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
        $solde = (new CaisseController())->soldeCaisse();
        $entre = (new CaisseController())->entree(date('m'));
        $sortie = (new CaisseController())->sortie(date('m'));
        $clients = Clients::all();
        $fournisseurs = Fournisseurs::all();
//        $devis = Devis::all();
//        $factures =Factures::all();
//        $commandes= Commandes::all();
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
        foreach ($produit as $key => $item){
            $use = 0;
            foreach ($proFact as $pf){
                if ($pf->idproduit==$item->produit_id) {
                    $use += $pf->quantite;
                }
            }
            if ($item->quantite_produit-$use<=3) {
                $prodID[$item->produit_id] = $item->produit_id;
            }
        }
        $stock = Produits::whereIn('produit_id',$prodID)->get();
        $charges = Charges::all();
        $taches = Taches::all();
        $taches = Taches::whereMonth('created_at',date('m') )->get();
        $lastactivity = Devis::join('users','users.id','devis.iduser')->where('devis.created_at','>=',$date)->orderBy('devis.created_at','desc')->get();
        $lastactivity1 = Factures::join('users','users.id','factures.iduser')->where('factures.created_at','>=',$date)->orderBy('factures.created_at','desc')->get();
        $lastactivity2 = Commandes::join('users','users.id','commandes.iduser')->where('commandes.created_at','>=',$date)->orderBy('commandes.created_at','desc')->get();
        $lastactivity3 = Taches::join('users','users.id','taches.iduser')->where('taches.created_at','>=',$date)->orderBy('taches.created_at','desc')->get();
        return view('dashboard',compact('clients','fournisseurs','devisNV',
        'commandesNV','factureNV','devisSF','lastactivity','lastactivity1','lastactivity2','charges','taches','lastactivity3','stock',
        'produit','solde', 'entre', 'sortie',
        ));
    }

    public function text()
    {
        return redirect(route('home'))->with('warning','Un bon test reuissi toujours!');
    }

    public function loadDepences(Request $request){
        if ($request->ajax()) {
            $request->validate([
                'date' => 'required'
            ]);
            $data=[];
            $date ='';
            $date .= $request->date[5];
            $date .= $request->date[6];
//            $date = new DateTime($date);
//            $date->sub(new DateInterval("P1D"));
//                dd($date);
//            $date = date("m", strtotime($date->format('m')));
//            $solde = (new CaisseController())->soldeCaisse();
            $entre = (new CaisseController())->entree((Int)$date);
            $sortie = (new CaisseController())->sortie((Int)$date);
            $taches = Taches::whereMonth('created_at',(Int)$date )->get();
            $data['entre'] = $entre;
            $data['sortie'] = $sortie;
            $data['tache'] = count($taches);
            $data['mois'] = $date;
            return Response()->json($data);
        }
    }

}
