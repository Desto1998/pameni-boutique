<?php

namespace App\Http\Controllers;

use App\Models\Avoirs;
use App\Models\BonLivraison;
use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commentaires;
use App\Models\Devis;
use App\Models\Paiements;
use App\Models\ProduitAvoir;
use App\Models\ProduitBon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
