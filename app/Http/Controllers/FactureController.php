<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commandes;
use App\Models\Commentaires;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Paiements;
use App\Models\Pays;
use App\Models\Pieces;
use App\Models\Produit_Factures;
use App\Models\Produits;
use App\Models\User;
use DateInterval;
use DateTime;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use PhpParser\Node\Expr\Array_;
use Yajra\DataTables\DataTables;

class FactureController extends Controller
{
    //
    public function index()
    {
        $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
            ->orderBy('factures.created_at', 'desc')
            ->get();
        $users = User::all();
        $pocedes = Produit_Factures::all();
        $paiements = Paiements::all();
        return view('facture.index',
            compact('data', 'users', 'paiements', 'pocedes')
        );
    }

    public function loadFactures($id)
    {
        if ($id<=0) {
            $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                ->join('users', 'users.id', 'factures.iduser')
                ->orderBy('factures.created_at', 'desc')
                ->get();
        }else {
            $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                ->join('users', 'users.id', 'factures.iduser')
                ->where('factures.idclient',$id)
                ->orderBy('factures.created_at', 'desc')
                ->get();
        }

//        $product  = new Array_();
        return Datatables::of($data)
            ->addIndexColumn()
            //Ajoute de la colonne action
            ->addColumn('action', function ($value) {
                $categories = Categories::all();
                $paiements = Paiements::where('idfacture', $value->facture_id)->get();
                $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $value->facture_id)->get();
                $action = view('facture.action', compact('value', 'categories', 'pocedes', 'paiements'));
//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                return (string)$action;
            })
            // Le nom client Ajout de la colonne
            ->addColumn('client', function ($value) {
                $client = $value->nom_client . ' ' . $value->prenom_client . ' ' . $value->raison_s_client;
                return $client;
            })
            // ajout d'une colonne pour le montant de paieent deja effectueerr
            ->addColumn('paye', function ($value) {
                return (new Factures())->Payer($value->facture_id);
            })
            // Ajout du statut du. colonne marque en rouge | Si le statut est 0? NValide : Valide
            ->addColumn('statut', function ($value) {

                if ($value->statut == 0) {
                    $statut = '<span class="text-danger">Non validé</span>';
                } else {
                    $statut = '<span class="text-success">Validé</span>';
                }
                return $statut;
            })
            // calcule du montant hors taxe
            ->addColumn('montantHT', function ($value) {
                $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $value->facture_id)->get();
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

                return (new Factures())->montantTotal($value->facture_id);

            })
            ->rawColumns(['action', 'montantHT', 'montantTTC', 'statut', 'paye'])
            ->make(true);
    }


    public function showAddForm()
    {
        $produits = Produits::orderBy('created_at', 'desc')->get();
        $ID = [];
        foreach ($produits as $key => $value) {
            if (!in_array($value->idcategorie, $ID)) {
                $ID[$key] = $value->idcategorie;
            }
        }
        $categories = Categories::whereIn('categorie_id', $ID)->orderBy('categories.created_at', 'desc')->get();
        $pays = Pays::orderBy('nom_pays','asc')->get();
        $clients = Clients::orderBy('created_at', 'desc')->get();
        return view('facture.create', compact('categories', 'produits', 'clients', 'pays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            // 'ref_bon' => ['required'],
        ]);
//        dd($request);
//        $lastNum = Devis::whereYear('created_at', date('Y'))->ma('devis_id')->get() ;
        $lastNum = Factures::whereYear('created_at', date('Y'))
            ->whereRaw('facture_id = (select max(`facture_id`) from factures)')
            ->get();

        $iduser = Auth::user()->id;
//        $date = new DateTime($request->date);
////        $date->sub(new DateInterval('P1D'));
//        $nbjour = $request->validite * 7;
//        $date->add(new DateInterval("P{$nbjour}D"));
//        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

        /** @var 'on' genere la  $reference */
        $reference = 'F' . date('Y');
        if (count($lastNum) > 0) {
            $lastNum = $lastNum[0]->reference_fact;
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
        $save = Factures::create([
            'reference_fact' => $reference,
            'disponibilite' => $request->disponibilite,
            'garentie' => $request->garentie,
            'objet' => $request->objet,
            'condition_financiere' => $request->condition,
            'date_fact' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->idproduit); $i++) {
            Produit_Factures::create([
                'idfacture' => $save->facture_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' => 0, //$request->tva[$i],
                'remise' => $request->remise[$i],
                'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        // On enregistre les infos du bon de commande
        if (isset($request->ref_bon)) {
            $file = $request->file('logo');
            $destinationPath = 'images/piece';
            $originalFile = "";
            if ($file) {
                $originalFile = $file->getClientOriginalName();
                $file->move($destinationPath, $originalFile);
            }
            Pieces::create([
                'chemin' => $originalFile,
                'ref' => $request->ref_bon,
                'date_piece' => $request->date_bon,
                'idfacture' => $save->facture_id,
                'iduser' => $iduser,
            ]);
        }
        if ($save) {
            return redirect()->route('factures.all')->with('success', 'Enregistré avec succès!');
        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function removeProduit(Request $request)
    {
        $request->validate([
            'id' => ['required']
        ]);
        $remove = Produit_Factures::where('produit_f_id', $request->id)->delete();
        return Response()->json($remove);
    }

    public function viewDetail($id)
    {
        $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        $montantTVA = 0;

        $montantTVA = (new Factures())->montantHT($id);
        $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
        ->join('users', 'users.id', 'factures.iduser')
        ->where('facture_id', $id)
        ->get()
    ;
        if ($data[0]->tva_statut == 1) {
            $montantTTC = (($montantTVA * 19.25) / 100) + $montantTVA;
        } else {
            $montantTTC = $montantTVA;
        }
        $paiements = Paiements::where('idfacture',$id)->get();
        $commentaires = Commentaires::join('users','users.id','commentaires.iduser')->where('idfacture',$id)->get();

        $piece = Pieces::where('idfacture', $id)->get();
        return view('facture.details.index', compact('data','pocedes',
        'montantTTC','montantTVA','commentaires','paiements','piece')) ;
    }

    public function showEditForm($id)
    {
        $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
            ->join('users', 'users.id', 'factures.iduser')
            ->where('facture_id', $id)
            ->get()
        ;
//        $categories = Categories::all();
        $produits = Produits::orderBy('created_at', 'desc')->get();
        $ID = [];
        foreach ($produits as $key => $value) {
            if (!in_array($value->idcategorie, $ID)) {
                $ID[$key] = $value->idcategorie;
            }
        }
        $piece = Pieces::where('idfacture', $id)->get();
        $categories = Categories::whereIn('categorie_id', $ID)->orderBy('categories.created_at', 'desc')->get();
        $clients = Clients::orderBy('created_at', 'desc')->get();
        $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        return view('facture.edit', compact('data', 'piece', 'categories', 'pocedes', 'clients', 'produits'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            // 'ref_bon' => ['required'],
            'facture_id' => ['required'],
        ]);

        $iduser = Auth::user()->id;

//        dd($reference); updateOrCreate
        $save = Factures::where('facture_id', $request->facture_id)->update([
            'objet' => $request->objet,
            'condition_financiere' => $request->condition,
            'date_fact' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->idproduit); $i++) {
            $pocedeId = '';
            if (isset($request->produit_f_id[$i]) && !empty($request->produit_f_id[$i])) {
                $pocedeId = $request->produit_f_id[$i];
            }
            Produit_Factures::updateOrCreate(['produit_f_id' => $pocedeId], [
                'idfacture' => $request->facture_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' => 0, //$request->tva[$i],
                'remise' => $request->remise[$i],
                'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        // On enregistre les infos du bon de commande
        if (isset($request->ref_bon)) {
            $file = $request->file('logo');
            $destinationPath = 'images/piece';
            $originalFile = "";
            if ($file) {
                $originalFile = $file->getClientOriginalName();
                $file->move($destinationPath, $originalFile);
            } else {
                $originalFile = $request->chemin;
            }
            Pieces::updateOrCreate(['piece_id' => $request->piece_id], [
                'chemin' => $originalFile,
                'ref' => $request->ref_bon,
                'date_piece' => $request->date_bon,
                'idfacture' => $request->facture_id,
                'iduser' => $iduser,
            ]);
        }
        /** on modifie le statut de son devis et on met a 1. Pour que ca reste a valide
         * au lieu de facture creee
        **/
        $fact = Factures::where('facture_id',$request->facture_id)->get();
        if (count($fact)>0) {
            if (isset($fact[0]->iddevis) && !empty($fact[0]->iddevis)) {
                Devis::where('devis_id',$fact[0]->iddevis)->update(['statut'=>1]);

            }
        }
        if ($save) {
            return redirect()->route('factures.all')->with('success', 'Enregistré avec succès!');
        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function delete(Request $request)
    {
        Produit_Factures::where('idfacture', $request->id)->delete();
        Paiements::where('idfacture', $request->id)->delete();
        $delete = Factures::where('idfacture', $request->id)->delete();
        return Response()->json($delete);
    }

    public function getDetails($id)
    {
        return 'in process';
    }


    public function validerFactures(Request $request)
    {
        $statut = Factures::where('facture_id', $request->id)->update(['statut' => 1]);
        return Response()->json($statut);
    }

    public function bloquerFactures(Request $request)
    {
        $statut = Factures::where('facture_id', $request->id)->update(['statut' => 0]);
        return Response()->json($statut);
    }

    public function printFactures($id)
    {
        $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
            ->join('users', 'users.id', 'factures.iduser')
            ->where('facture_id', $id)
            ->get();
        $date = new DateTime($data[0]->date_fact);
        $date = $date->format('m');
        $piece = Pieces::where('idfacture', $id)->get();
        $num_BC = isset($piece[0]) ? $piece[0]->ref : '';
        $mois = (new \App\Models\Month)->getFrenshMonth((int)$date);
        $categories = Categories::all();
        $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        $pdf = PDF::loadView('facture.print', compact('data', 'num_BC', 'mois', 'categories', 'pocedes'))->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($data[0]->reference_fact . '_' . date("d-m-Y H:i:s") . '.pdf');
    }

    public function addPaiement(Request $request)
    {
        $request->validate([
            'montant' => ['required'],
            'mode' => ['required'],
            'idfacture' => ['required'],
        ]);
        $dataID = $request->paiement_id;
        $iduser = Auth::user()->id;
        $save = Paiements::updateOrCreate(['paiement_id' => $dataID], [
            'idfacture' => $request->idfacture,
            'mode' => $request->mode,
            'montant' => $request->montant,
            'description' => $request->description,
            'date_paiement' => date('Y-m-d'),
            'statut' => 1,
            'iduser' => $iduser,
        ]);
        if ($save && $request->mode == "Espèce") {
            $factData = new Array_();
            $factData->key = 'PAIEMENT';
            $factData->raison = 'Versement pour facture';
            $factData->montant = $request->montant;
            $factData->description = $request->description;
            $factData->id = $save->paiement_id;

            if ((new CaisseController())->storeCaisse($factData)) {
                $statut = 2;
            }
        }
        return Response()->json($save);

    }

    public function deletePaiement(Request $request)
    {
        $delete = Paiements::where('paiement_id', $request->id)->delete();
        if ($delete) {
            $d = (new CaisseController())->removeFromCaisse($request->id, 'PAIEMENT');
        }
        return Response()->json($delete);
    }

    public function checkAmount(Request $request){

        return (new Factures())->montantTotal($request->id)- (new Factures())->Payer($request->id);
    }
}
