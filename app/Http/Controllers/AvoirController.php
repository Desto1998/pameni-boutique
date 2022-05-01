<?php

namespace App\Http\Controllers;

use App\Models\Avoirs;
use App\Models\BonLivraison;
use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commentaires;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Month;
use App\Models\Paiements;
use App\Models\Pays;
use App\Models\Pieces;
use App\Models\Produit_Factures;
use App\Models\ProduitAvoir;
use App\Models\Produits;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpParser\Node\Expr\Array_;
use Yajra\DataTables\DataTables;

class AvoirController extends Controller
{
    //
    public function index()
    {
        $factures = Factures::where('statut',1)->get();
        $data = Avoirs::join('users', 'users.id', 'avoirs.iduser')
            ->orderBy('avoirs.created_at', 'desc')
            ->get()
        ;

        $users = User::all();
        $TID = [];
        foreach ($factures as $key=>$value){
            $TID[$key] = $value->facture_id;
        }
        $produits = Produit_Factures::join('produits','produits.produit_id','produit_factures.idproduit')->get();
        return view('fature_avoir.index',
            compact('data', 'users','factures','produits')
        );
    }

    public function loadAvoir($id)
    {
        if ($id<=0) {
            $data = Avoirs::join('users', 'users.id', 'avoirs.iduser')
                ->orderBy('avoirs.created_at', 'desc')
                ->get()
            ;
        }else {
            $data = Avoirs::whereRaw('avoirs.idfacture in (select facture_id from factures where idclient = '.$id.')  ')
                ->join('users', 'users.id', 'avoirs.iduser')
                ->orderBy('avoirs.created_at', 'desc')
                ->get()
            ;
        }

//        $product  = new Array_();
        return Datatables::of($data)
            ->addIndexColumn()
            //Ajoute de la colonne action
            ->addColumn('action', function ($value) {
                $categories = Categories::all();
//                $paiements = Paiements::where('idfacture', $value->facture_id)->get();
                $pocedes = (new ProduitAvoir)->produitAvoir($value->avoir_id);
                $factures = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                    ->where('factures.facture_id',$value->idfacture)
                    ->get();
                $action = view('fature_avoir.action', compact('value', 'categories', 'pocedes','factures', ));
//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                return (string)$action;
            })
            // Le nom client Ajout de la colonne
            ->addColumn('client', function ($value) {
                $factures = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                    ->where('factures.facture_id',$value->idfacture)
                    ->get();
                $client = $factures[0]->nom_client . ' ' . $factures[0]->prenom_client . ' ' . $factures[0]->raison_s_client;
                return $client;
            })
            // Reference de la facture
            ->addColumn('facture', function ($value) {
                $factures = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                    ->where('factures.facture_id',$value->idfacture)
                    ->get();
                $factID = $factures[0]->facture_id;
                $route = route('factures.view',['id'=>$factID]);
                $ref = $factures[0]->reference_fact;
                $client ="<a href=\" $route \" target='_blank' title='Cliquer pour voir la facture.' class='link'>$ref</a>" ;
                return $client;
            })
            // ajout d'une colonne pour le montant de paieent deja effectueerr
//            ->addColumn('paye', function ($value) {
//                return (new Factures())->Payer($value->facture_id);
//            })
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
                $pocedes = (new ProduitAvoir)->produitAvoir($value->avoir_id);
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

                return (new Avoirs())->montantTotal($value->avoir_id);

            })
            ->rawColumns(['action', 'montantHT', 'montantTTC', 'statut', 'facture'])
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
            // 'prix' => ['required'],
            // 'ref_bon' => ['required'],
        ]);

        $lastNum = Avoirs::whereYear('created_at', date('Y'))
            ->whereRaw('avoir_id = (select max(`avoir_id`) from avoirs)')
            ->get();

        $iduser = Auth::user()->id;
//        $date = new DateTime($request->date);
////        $date->sub(new DateInterval('P1D'));
//        $nbjour = $request->validite * 7;
//        $date->add(new DateInterval("P{$nbjour}D"));
//        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

        /** @var 'on' genere la  $reference */
        $reference = 'FA' . date('Y');
        if (count($lastNum) > 0) {
            $lastNum = $lastNum[0]->reference_avoir;
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
        $save = Avoirs::create([
            'reference_avoir' => $reference,
            'objet' => $request->objet,
            'date_avoir' => $request->date,
            'idfacture' => $request->idfacture,
            'tva_statut' => $request->tva_statut[$request->idfacture],
            'iduser' => $iduser,
            'statut' => 0,
        ]);
        for ($i = 0; $i < count($request->produit_f_id); $i++) {
            $produtInfos = Produit_Factures::where('produit_f_id', $request->produit_f_id[$i])->get();
            ProduitAvoir::create([
                'idavoir' => $save->avoir_id,
                'quantite' => $request->quantite[$request->produit_f_id[$i]],
                'prix' => $produtInfos[0]->prix,
                'tva' => 0, //$request->tva[$i],
                'remise' => $produtInfos[0]->remise,
                'idproduit' => $produtInfos[0]->idproduit,
                'iduser' => $iduser,
            ]);
        }
        // On enregistre les infos du bon de commande
        return Response()->json($save);
//
//        if ($save) {
//
//        }
//        return '';
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
        $pocedes = (new ProduitAvoir())->produitAvoir($id);
        $montantTVA = 0;

        $montantTVA = (new Avoirs())->montantHT($id);

        $data = Avoirs::join('users', 'users.id', 'avoirs.iduser')
            ->orderBy('avoirs.created_at', 'desc')
            ->get()
        ;
        $factures = Factures::join('clients', 'clients.client_id', 'factures.idclient')
            ->where('factures.facture_id',$data[0]->idfacture)
            ->get();
        if ($data[0]->tva_statut == 1) {
            $montantTTC = (($montantTVA * 19.25) / 100) + $montantTVA;
        } else {
            $montantTTC = $montantTVA;
        }
        $commentaires = Commentaires::join('users','users.id','commentaires.iduser')->where('idavoir',$id)->get();

        return view('fature_avoir.details.index', compact('data','pocedes',
            'montantTTC','montantTVA','commentaires','factures')) ;
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
        ProduitAvoir::where('idavoir', $request->id)->delete();
        // Paiements::where('idfacture', $request->id)->delete();
        $delete = Avoirs::where('avoir_id', $request->id)->delete();
        return Response()->json($delete);
    }

    public function getDetails($id)
    {
        return 'in process';
    }


    public function validerAvoir(Request $request)
    {
        $statut = Avoirs::where('avoir_id', $request->id)->update(['statut' => 1]);
        $produits = ProduitAvoir::where('idavoir',$request->id)->get();
        foreach ($produits as $key=>$value){
            $updateP[$key] = Produits::where('produit_id',$value->idproduit)->update(['quantite_produit'=>DB::raw('quantite_produit + '.$value->quantite)]);
        }
        return Response()->json($statut);
    }

    public function bloquerAvoir(Request $request)
    {
        $statut = Avoirs::where('avoir_id', $request->id)->update(['statut' => 0]);
        return Response()->json($statut);
    }

    public function printFactures($id)
    {
        $data = Avoirs::join('users', 'users.id', 'avoirs.iduser')
            ->orderBy('avoirs.created_at', 'desc')
            ->get()
        ;
        $date = new DateTime($data[0]->date_avoir);
        $date = $date->format('m');
        $factures = Factures::join('clients', 'clients.client_id', 'factures.idclient')
            ->where('factures.facture_id',$data[0]->idfacture)
            ->get();
        $pocedes = (new ProduitAvoir())->produitAvoir($id);
        $mois = (new Month)->getFrenshMonth((int)$date);
        $categories = Categories::all();
//        $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        $pdf = PDF::loadView('fature_avoir.print', compact('data',  'mois', 'categories', 'pocedes','factures'))->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($data[0]->reference_avoir . '_' . date("d-m-Y H:i:s") . '.pdf');
    }

}
