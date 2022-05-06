<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commandes;
use App\Models\Commentaires;
use App\Models\Comportes;
use App\Models\Fournisseurs;
use App\Models\Pays;
use App\Models\Pieces;
use App\Models\Pocedes;
use App\Models\Produits;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;
use PDF;
use Yajra\DataTables\DataTables;

class CommandeController extends Controller
{
    public function index()
    {
        $data = Commandes::join('fournisseurs', 'fournisseurs.fournisseur_id', 'commandes.commande_id')
            ->orderBy('commandes.created_at', 'desc')
            ->get();
        $users = User::all();
        $pocedes = Comportes::all();
        return view('commande.index',
            compact('data', 'users', 'pocedes')
        );
    }

    public function loadCommandes($id)
    {
        if ($id>0) {
            $data = Commandes::join('fournisseurs', 'fournisseurs.fournisseur_id', 'commandes.idfournisseur')
                ->join('users', 'users.id', 'commandes.iduser')
                ->where('commandes.idfournisseur',$id)
                ->orderBy('commandes.created_at', 'desc')
                ->get();
        }else{
            $data = Commandes::join('fournisseurs', 'fournisseurs.fournisseur_id', 'commandes.idfournisseur')
                ->join('users', 'users.id', 'commandes.iduser')
                ->orderBy('commandes.created_at', 'desc')
                ->get();
        }

//        $product  = new Array_();
        return Datatables::of($data)
            ->addIndexColumn()
            //Ajoute de la colonne action
            ->addColumn('action', function ($value) {
                $categories = Categories::all();
//                $paiements = Paiements::where('idfacture', $value->facture_id)->get();
                $pocedes = Comportes::join('produits', 'produits.produit_id', 'comportes.idproduit')->where('idcommande', $value->commande_id)->get();
                $action = view('commande.action', compact('value', 'categories', 'pocedes'));
//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                return (string)$action;
            })
            // Le nom client Ajout de la colonne
            ->addColumn('client', function ($value) {
                $client = $value->nom_fr . ' ' . $value->prenom_fr . ' ' . $value->raison_s_fr;
                return $client;
            })
            // Ajout du statut du. colonne marque en rouge | Si le statut est 0? NValide : Valide
            ->addColumn('statut', function ($value) {

                if ($value->statut == 0) {
                    $statut = '<span class="text-danger">Non validé</span>';
                }
                if ($value->statut == 1) {
                    $statut = '<span class="text-success">Validé</span>';
                }
                if ($value->statut > 1) {
                    $statut = '<span class="text-primary"><i class="fa fa-check"></i>&nbsp; &nbsp;Livré</span>';
                }
                return $statut;
            })
            // calcule du montant hors taxe
            ->addColumn('montantHT', function ($value) {
                $pocedes = Comportes::join('produits', 'produits.produit_id', 'comportes.idproduit')->where('idcommande', $value->commande_id)->get();
                $montantHT = 0;

                foreach ($pocedes as $p) {
                    $remise = ($p->prix * $p->quantite * $p->remise) / 100;
                    $montant = ($p->quantite * $p->prix) - $remise;
                    $montantHT += $montant;
                }
                return number_format($montantHT, 2, '.', '');
            })
            // calcule du montant TTC tout taxe comprie
            ->addColumn('montantTTC', function ($value) {
                $pocedes = Comportes::join('produits', 'produits.produit_id', 'comportes.idproduit')->where('idcommande', $value->commande_id)->get();
                $montantTVA = 0;
                $montantTTC = 0;
                foreach ($pocedes as $p) {
                    $remise = ($p->prix * $p->quantite * $p->remise) / 100;
                    $montant = ($p->quantite * $p->prix) - $remise;
                    $tva = ($montant * $p->tva) / 100;
                    $montant = $tva + $montant;
//                        $montant += (($montant * 19.25)/100)+$montant;
                    $montantTVA += $montant;

                }
                if ($value->tva_statut == 1) {
                    $montantTTC = (($montantTVA * 19.25) / 100) + $montantTVA;
                }else{
                    $montantTTC = $montantTVA;
                }

                return number_format($montantTTC, 2, '.', '');

            })
            ->rawColumns(['action', 'montantHT', 'montantTTC', 'statut'])
            ->make(true);
    }


    public function showAddForm()
    {
        $produits = Produits::orderBy('created_at', 'desc')->get();
        $ID = [];
        foreach ($produits as $key =>$value){
            if (!in_array($value->idcategorie,$ID)) {
                $ID[$key]=$value->idcategorie;
            }
        }
        $categories = Categories::whereIn('categorie_id',$ID )->orderBy('categories.created_at', 'desc')->get();
        $pays = Pays::orderBy('nom_pays','asc')->get();
        $clients = Fournisseurs::orderBy('created_at', 'desc')->get();
        return view('commande.create', compact('categories', 'produits', 'clients','pays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            'mode' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            //'ref_bon' => ['required'],
        ]);
//        dd($request);
//        $lastNum = Devis::whereYear('created_at', date('Y'))->ma('devis_id')->get() ;
        $lastNum = Commandes::whereYear('created_at', date('Y'))
            ->whereRaw('commande_id = (select max(`commande_id`) from commandes)')
            ->get();

        $iduser = Auth::user()->id;
//        $date = new DateTime($request->date);
////        $date->sub(new DateInterval('P1D'));
//        $nbjour = $request->validite * 7;
//        $date->add(new DateInterval("P{$nbjour}D"));
//        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

        /** @var 'on' genere la  $reference */
        $reference = 'BC' . date('Y');
        if (count($lastNum) > 0) {
            $lastNum = $lastNum[0]->reference_commande;
            $actual = 0;
            for ($j = 0; $j < strlen($lastNum); $j++) {
                if ($j > 5) {
                    $actual .= $lastNum[$j];
                }
            }
            $num = (int)$actual;
            $num += 1;
            $actual = str_pad($num, 3, "0", STR_PAD_LEFT);
            $reference .= $actual;
        } else {
            $num = 1;
            $actual = str_pad($num, 3, "0", STR_PAD_LEFT);
            $reference .= $actual;
        }
//        dd($reference);
        $save = Commandes::create([
            'reference_commande' => $reference,
            'objet' => $request->objet,
            'date_commande' => $request->date,
            'statut' => 0,
            'idfournisseur' => $request->idfournisseur,
           // 'disponibilite' => $request->disponibilite,
           // 'service' => $request->service,
            'condition_paiement' => $request->condition,
            'mode_paiement' => $request->mode,
           // 'direction' => $request->mode,
            'delai_liv' => $request->delai,
            'observation' => $request->observation,
            'lieu_liv' => $request->lieu_livraison,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->idproduit); $i++) {
            Comportes::create([
                'idcommande' => $save->commande_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' =>0, // $request->tva[$i],
                'remise' => $request->remise[$i],
                'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        // On enregistre les infos du bon de commande
        if (isset($request->ref_bon)) {
            $file = $request->file('logo');
            $destinationPath = 'images/piece';
            $originalFile ="";
            if ($file) {
                $originalFile = $file->getClientOriginalName();
                $file->move($destinationPath, $originalFile);
            }
            Pieces::create([
                'chemin' => $originalFile,
                'ref' => $request->ref_bon,
                'date_piece' => $request->date_bon,
                'idcommande' => $save->commande_id,
                'iduser' => $iduser,
            ]);
        }
        if ($save) {
            return redirect()->route('commandes.all')->with('success', 'Enregistré avec succès!');
        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function removeProduit(Request $request){
        $request->validate([
            'id'=>['required']
        ]);
        $remove = Comportes::where('comporte_id',$request->id)->delete();
        return Response()->json($remove);
    }

    public function viewDetail($id)
    {
        $pocedes = Comportes::join('produits', 'produits.produit_id', 'comportes.idproduit')->where('idcommande', $id)->get();
        $montantTVA = 0;
        $montantTTC = 0;
        foreach ($pocedes as $p) {

            $remise = ($p->prix * $p->quantite * $p->remise) / 100;
            $montant = ($p->quantite * $p->prix) - $remise;
            $tva = ($montant * $p->tva) / 100;
            $montant = $tva + $montant;
//                        $montant += (($montant * 19.25)/100)+$montant;
            $montantTVA += $montant;

        }
        $data = Commandes::join('fournisseurs', 'fournisseurs.fournisseur_id', 'commandes.idfournisseur')
            ->join('users', 'users.id', 'commandes.iduser')
            ->where('commande_id', $id)
            ->get()
        ;
        if ($data[0]->tva_statut == 1) {
            $montantTTC = (($montantTVA * 19.25) / 100) + $montantTVA;
        } else {
            $montantTTC = $montantTVA;
        }

        $commentaires = Commentaires::join('users','users.id','commentaires.iduser')->where('idcommande',$id)->get();

        $piece = Pieces::where('idcommande', $id)->get();
        return view('commande.details.index', compact('data','pocedes','montant',
            'montantTTC','montantTVA','commentaires','piece')) ;

    }
    public function showEditForm($id)
    {
        $data = Commandes::join('fournisseurs', 'fournisseurs.fournisseur_id', 'commandes.idfournisseur')
            ->join('users', 'users.id', 'commandes.iduser')
            ->where('commande_id', $id)
            ->get()
        ;
//        $categories = Categories::all();
        $produits = Produits::orderBy('created_at', 'desc')->get();
        $ID = [];
        foreach ($produits as $key =>$value){
            if (!in_array($value->idcategorie,$ID)) {
                $ID[$key]=$value->idcategorie;
            }
        }
        $pays = Pays::all();
        $piece = Pieces::where('idcommande',$id)->get();
        $categories = Categories::whereIn('categorie_id',$ID )->orderBy('categories.created_at', 'desc')->get();
        $fournisseurs = Fournisseurs::orderBy('created_at', 'desc')->get();
        $pocedes = Comportes::join('produits', 'produits.produit_id', 'comportes.idproduit')->where('idcommande', $id)->get();
        return view('commande.edit',compact('data','pays','piece','categories','pocedes','fournisseurs','produits'));
    }
    public function edit(Request $request)
    {
//        dd($request);
        $request->validate([
            'date' => ['required'],
            'objet' => ['required'],
            'quantite' => ['required'],
            'prix' => ['required'],
            'ref_bon' => ['required'],
            'commande_id' => ['required'],
            'idfournisseur' => ['required'],
            'idproduit' => ['required'],
        ]);

        $iduser = Auth::user()->id;

//        dd($reference); updateOrCreate
        $save = Commandes::where('commande_id',$request->commande_id)->update([
            'objet' => $request->objet,
            'date_commande' => $request->date,
            'statut' => 0,
            'idfournisseur' => $request->idfournisseur,
            // 'service' => $request->service,
            'condition_paiement' => $request->condition,
            'mode_paiement' => $request->mode,
            // 'direction' => $request->mode,
            'delai_liv' => $request->delai,
            'observation' => $request->observation,
            'lieu_liv' => $request->lieu_livraison,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->idproduit); $i++) {
            $pocedeId = '';
            if (isset($request->comporte_id[$i]) && !empty($request->comporte_id[$i])) {
                $pocedeId = $request->comporte_id[$i];
            }
            Comportes::updateOrCreate(['comporte_id'=>$pocedeId],[
                'idcommande' => $request->commande_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' => 0,//$request->tva[$i],
                'remise' => $request->remise[$i],
                'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        // On enregistre les infos du bon de commande
        if (isset($request->ref_bon)) {
            $file = $request->file('logo');
            $destinationPath = 'images/piece';
            $originalFile ="";
            if ($file) {
                $originalFile = $file->getClientOriginalName();
                $file->move($destinationPath, $originalFile);
            }else{
                $originalFile =$request->chemin;
            }
            Pieces::updateOrCreate(['piece_id'=>$request->piece_id],[
                'chemin' => $originalFile,
                'ref' => $request->ref_bon,
                'date_piece' => $request->date_bon,
                'idcommande' => $request->commande_id,
                'iduser' => $iduser,
            ]);
        }

        if ($save) {
            return redirect()->route('commandes.all')->with('success', 'Enregistré avec succès!');
        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }
    public function delete(Request $request){
        Comportes::where('idcommande',$request->id)->delete();
//        Paiements::where('idfacture',$request->id)->delete();
        $delete  = Commandes::where('idfacture',$request->id)->delete();
        return Response()->json($delete);
    }

    public function getDetails($id){
        return 'in process';
    }


    public function validerCommande(Request $request)
    {
        $statut = Commandes::where('commande_id', $request->id)->update(['statut' => 1]);
        return Response()->json($statut);
    }

    public function bloquerCommande(Request $request)
    {
        $statut = Commandes::where('commande_id', $request->id)->update(['statut' => 0]);
        return Response()->json($statut);
    }

    public function printCommandes($id)
    {
        $data = Commandes::join('fournisseurs', 'fournisseurs.fournisseur_id', 'commandes.idfournisseur')
            ->join('users', 'users.id', 'commandes.iduser')
            ->where('commande_id', $id)
            ->get()
        ;
        $date = new DateTime($data[0]->date_commande);
        $date = $date->format('m');
        $piece = Pieces::where('idcommande',$id)->get();
//        dd($piece);
        $num_BC = isset($piece[0])?$piece[0]->ref:'';
        $mois = (new \App\Models\Month)->getFrenshMonth((int)$date);
        $categories = Categories::all();
        $pocedes = Comportes::join('produits', 'produits.produit_id', 'comportes.idproduit')->where('idcommande', $id)->get();
        $pdf = PDF::loadView('commande.print', compact('data', 'num_BC','mois','categories', 'pocedes','piece'))->setPaper('a4', 'portrait')->setWarnings(false);
        // dd($pdf);
        return $pdf->stream($data[0]->reference_commande . '_' .date("d-m-Y H:i:s") . '.pdf');
    }

    public function migrateToStock(Request $request){
        if ($request->ajax()) {
            $id = $request->id;
            $productCMD = Comportes::where('idcommande',$id)->get();
            foreach ($productCMD as $key=> $value){
                $updateP[$key] = Produits::where('produit_id',$value->idproduit)->update(['quantite_produit'=>DB::raw('quantite_produit + '.$value->quantite)]);
            }
            if ($updateP) {
                Commandes::where('commande_id',$id)->update(['statut'=>2]);
            }
            return Response()->json($updateP);
        }
        return "";
    }
}
