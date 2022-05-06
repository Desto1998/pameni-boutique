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
        return view('bon_livraison.index',compact('devis'));
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
                $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                    ->where('devis.devis_id',$value->iddevis)
                    ->get();
                $categories = Categories::all();
                $paiements = Paiements::where('idfacture', $value->facture_id)->get();
                $pocedes = (new ProduitBon)->produitBon($value->bonlivrison_id);
                $action = view('fature_avoir.action', compact('value', 'categories', 'pocedes', 'paiements','devis'));
//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                return (string)$action;
            })
            // Le nom client Ajout de la colonne
            ->addColumn('client', function ($value) {
                $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                    ->where('devis.devis_id',$value->iddevis)
                    ->get();
                $client = $devis[0]->nom_client . ' ' . $devis[0]->prenom_client . ' ' . $devis[0]->raison_s_client;
                return $client;
            })
            // La refe du devis
            ->addColumn('devis', function ($value) {
                $devis = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                    ->where('devis.devis_id',$value->iddevis)
                    ->get();

                $ref = "<a class='link text-primary' href=\"{{ route('devis.view',['id'=>$devis[0]->devis_id) }}\"></a>";
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
    public function printBon($id)
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
        $num_BC = '';
        $mois = (new \App\Models\Month)->getFrenshMonth((int)$date);
        $categories = Categories::all();
        $pdf = PDF::loadView('bon_livraison.print', compact('data', 'num_BC', 'mois','devis', 'categories', 'pocedes'))->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($data[0]->reference_bl . '_' . date("d-m-Y H:i:s") . '.pdf');
    }

}
