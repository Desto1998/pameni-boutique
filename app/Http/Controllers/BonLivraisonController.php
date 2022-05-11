<?php

namespace App\Http\Controllers;

use App\Models\Avoirs;
use App\Models\BonLivraison;
use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commentaires;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Paiements;
use App\Models\Pieces;
use App\Models\Produit_Factures;
use App\Models\ProduitAvoir;
use App\Models\ProduitBon;
use App\Models\Produits;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\DataTables\DataTables;

class BonLivraisonController extends Controller
{
    //
    public function index(){
        $devis = Devis::where('statut','>',0)->get();
        $factures = Factures::where('statut','>',0)->get();
        return view('bon_livraison.index',compact('factures','devis'));
    }
    public function loadBon($id)
    {
        if ($id<=0) {
            // $clients = Clients::all();
//            $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
//                ->join('users', 'users.id', 'devis.iduser')
//                ->orderBy('devis.created_at', 'desc')
//                ->get();
            $data = BonLivraison::join('users', 'users.id', 'bon_livraisons.iduser')
                ->orderBy('bon_livraisons.created_at', 'desc')
                ->get()
            ;
        }else {
//            $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
//                ->join('users', 'users.id', 'devis.iduser')
//                ->where('devis.idclient',$id)
//                ->orderBy('devis.created_at', 'desc')
//                ->get();
            $data = BonLivraison::whereRaw('iddevis in (select devis_id from devis where idclient = '.$id.')  ')
                ->join('users', 'users.id', 'bon_livraisons.iduser')
                ->orderBy('bon_livraisons.created_at', 'desc')
                ->get()
            ;
        }

//        $product  = new Array_();
        return Datatables::of($data)
            ->addIndexColumn()
            //Ajoute de la colonne action
            ->addColumn('action', function ($value) {
//                $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
//                    ->where('devis.devis_id',$value->iddevis)
//                    ->get();
                if (!empty($value->iddevis)) {
                    $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                        ->where('devis.devis_id',$value->iddevis)
                        ->get();
                }else{
                    $devis = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                        ->where('factures.facture_id',$value->idfacture)
                        ->get();
                }
                $categories = Categories::all();
                $paiements = Paiements::where('idfacture', $value->facture_id)->get();
                $pocedes = (new BonLivraison())->getProduit($value->bonlivraison_id);
                $action = view('bon_livraison.action', compact('value', 'categories', 'pocedes', 'paiements','devis'));
//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                return (string)$action;
            })
            // Le nom client Ajout de la colonne
            ->addColumn('client', function ($value) {
                if (!empty($value->iddevis)) {
                    $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                        ->where('devis.devis_id',$value->iddevis)
                        ->get();
                }else{
                    $devis = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                        ->where('factures.facture_id',$value->idfacture)
                        ->get();
                }

                $client = $devis[0]->nom_client . ' ' . $devis[0]->prenom_client . ' ' . $devis[0]->raison_s_client;
                return $client;
            })
            // La refe du devis
            ->addColumn('devis', function ($value) {
                if (!empty($value->iddevis)) {
                    $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                        ->where('devis.devis_id',$value->iddevis)
                        ->get();
                    $route = route('devis.view',['id'=>$devis[0]->devis_id]);
                    $ref = $devis[0]->reference_devis;
                    $ref = "<a class='link text-primary' target='_blank' href=\"$route\">$ref</a>";

                }else{
                    $devis = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                        ->where('factures.facture_id',$value->idfacture)
                        ->get();
                    $route = route('factures.view',['id'=>$devis[0]->facture_id]);
                    $ref = $devis[0]->reference_fact;
                    $ref = "<a class='link text-success' target='_blank' href=\"$route\">$ref</a>";

                }


                return $ref;
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

            ->rawColumns(['action', 'statut','client','devis'])
            ->make(true)
        ;
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
//            'quantite' => ['required'],
            // 'prix' => ['required'],
            // 'ref_bon' => ['required'],
        ]);
        $check = BonLivraison::where('iddevis',$request->iddevis)
            ->OrWhere('idfacture',$request->idfacture)
            ->get();
        if (count($check)>0) {
            return -1;
        }
        $lastNum = BonLivraison::whereYear('created_at', date('Y'))
            ->whereRaw('bonlivraison_id = (select max(`bonlivraison_id`) from bon_livraisons)')
            ->get();

        $iduser = Auth::user()->id;

        /** @var 'on' genere la  $reference */
        $reference = 'BL' . date('Y');
        if (count($lastNum) > 0) {
            $lastNum = $lastNum[0]->reference_bl;
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
        $save = BonLivraison::create([
            'reference_bl' => $reference,
            'objet' => $request->objet,
            'date_bl' => $request->date,
            'idfacture' => $request->idfacture,
            'iddevis' => $request->iddevis,
            'lieu_liv' => $request->lieu_liv,
            'iduser' => $iduser,
            'statut' => 0,
        ]);
//        for ($i = 0; $i < count($request->produit_f_id); $i++) {
//            $produtInfos = Produit_Factures::where('produit_f_id', $request->produit_f_id[$i])->get();
//            ProduitAvoir::create([
//                'idavoir' => $save->avoir_id,
//                'quantite' => $request->quantite[$request->produit_f_id[$i]],
//                'prix' => $produtInfos[0]->prix,
//                'tva' => 0, //$request->tva[$i],
//                'remise' => $produtInfos[0]->remise,
//                'idproduit' => $produtInfos[0]->idproduit,
//                'iduser' => $iduser,
//            ]);
//        }
        // On enregistre les infos du bon de commande
        return Response()->json($save);
//
//        if ($save) {
//
//        }
//        return '';
    }

    public function viewDetail($id)
    {
        $data = BonLivraison::join('users', 'users.id', 'bon_livraisons.iduser')
            ->orderBy('bon_livraisons.created_at', 'desc')
            ->get()
        ;
        $date = new DateTime($data[0]->date_bl);
        $date = $date->format('m');
        $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
            ->where('devis.devis_id',$data[0]->iddevis)
            ->get();
        $pocedes = (new ProduitBon)->produitBon($data[0]->bonlivrison_id);

        $commentaires = Commentaires::join('users','users.id','commentaires.iduser')->where('idbonlivraison',$id)->get();

        return view('facture.details.index', compact('data','pocedes','devis',
           'commentaires')) ;
    }

    public function delete(Request $request)
    {
        ProduitBon::where('idbonlivraison', $request->id)->delete();
        $delete = BonLivraison::where('bonlivraison_id', $request->id)->delete();
        return Response()->json($delete);
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
        ]);

        $iduser = Auth::user()->id;
        $save = BonLivraison::create([
            'objet' => $request->objet,
            'date_bl' => $request->date,
            'lieu_liv' => $request->lieu_liv,
        ]);
        return $save;
//        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }
    public function printBon($id)
    {
        $data = BonLivraison::join('users', 'users.id', 'bon_livraisons.iduser')
            ->where('bonlivraison_id',$id)
            ->orderBy('bon_livraisons.created_at', 'desc')
            ->get()
        ;
        $date = new DateTime($data[0]->date_bl);
        $date = $date->format('m');
        if (!empty($data[0]->iddevis)) {
            $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                ->where('devis.devis_id',$data[0]->iddevis)
                ->get();
        }else{
            $devis = Factures::join('clients', 'clients.client_id', 'factures.idclient')
                ->where('factures.facture_id',$data[0]->idfacture)
                ->get();
        }
//        $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
//            ->where('devis.devis_id',$data[0]->iddevis)
//            ->get();
        $pocedes = (new BonLivraison())->getProduit($id);
//        $pocedes = (new ProduitBon)->produitBon($data[0]->bonlivrison_id);
        $num_BC = '';
        $mois = (new \App\Models\Month)->getFrenshMonth((int)$date);
        $categories = Categories::all();
        $pdf = PDF::loadView('bon_livraison.print', compact('data', 'num_BC', 'mois','devis', 'categories', 'pocedes'))->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($data[0]->reference_bl . '_' . date("d-m-Y H:i:s") . '.pdf');
    }

}
