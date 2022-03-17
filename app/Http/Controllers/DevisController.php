<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Complements;
use App\Models\Devis;
use App\Models\Month;
use App\Models\Paiements;
use App\Models\Pocedes;
use App\Models\Produits;
use App\Models\User;
use DateInterval;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Nette\Utils\DateTime;
use PDF;
use phpDocumentor\Reflection\Types\AbstractList;
use phpDocumentor\Reflection\Types\Array_;
use Yajra\DataTables\DataTables;

class DevisController extends Controller
{
    //List all devis
    public function index()
    {
        $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
            ->orderBy('devis.created_at', 'desc')
            ->get();
        $users = User::all();
        $complements = Complements::all();
        $pocedes = Pocedes::all();
        $paiements = Paiements::all();
        return view('devis.index',
            compact('data', 'users', 'complements', 'paiements', 'pocedes')
        );
    }

    public function loadDevis()
    {
        $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
            ->join('users', 'users.id', 'devis.iduser')
            ->orderBy('devis.created_at', 'desc')
            ->get();

//        $product  = new Array_();
        return Datatables::of($data)
            ->addIndexColumn()
            //Ajoute de la colonne action
            ->addColumn('action', function ($value) {
                $categories = Categories::all();
                $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $value->devis_id)->get();
                $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $value->devis_id)->get();
                $action = view('devis.action', compact('value', 'categories', 'pocedes', 'complements'));

//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                return (string)$action;
            })
            // Le nom client Ajout de la colonne
            ->addColumn('client', function ($value) {
                $client = $value->nom_client . ' ' . $value->prenom_client . ' ' . $value->raison_s_client;
                return $client;
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
                $pocedes = Pocedes::where('iddevis', $value->devis_id)->get();
                $montantHT = 0;

                foreach ($pocedes as $p) {
                    if ($p->iddevis === $value->devis_id) {
                        $remise = ($p->prix * $p->quantite * $p->remise) / 100;
                        $montant = ($p->quantite * $p->prix) - $remise;
                        $montantHT += $montant;
                    }
                }
                return number_format($montantHT, 2, '.', '');
            })
            // calcule du montant TTC tout taxe comprie
            ->addColumn('montantTTC', function ($value) {
                $pocedes = Pocedes::where('iddevis', $value->devis_id)->get();
                $montantTVA = 0;
                $montantTTC = 0;
                foreach ($pocedes as $p) {
                    if ($p->iddevis === $value->devis_id) {
                        $remise = ($p->prix * $p->quantite * $p->remise) / 100;
                        $montant = ($p->quantite * $p->prix) - $remise;
                        $tva = ($montant * $p->tva) / 100;
                        $montant = $tva + $montant;
//                        $montant += (($montant * 19.25)/100)+$montant;
                        $montantTVA += $montant;
                    }
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

        $clients = Clients::orderBy('created_at', 'desc')->get();
        return view('devis.create', compact('categories', 'produits', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            'validite' => ['required'],
            'disponibilite' => ['required'],
        ]);
//        dd($request);
//        $lastNum = Devis::whereYear('created_at', date('Y'))->ma('devis_id')->get() ;
        $lastNum = Devis::whereYear('created_at', date('Y'))
            ->whereRaw('devis_id = (select max(`devis_id`) from devis)')
            ->get();

        $iduser = Auth::user()->id;
        $date = new DateTime($request->date);
//        $date->sub(new DateInterval('P1D'));
        $nbjour = $request->validite * 7;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

        $reference = 'PF' . date('Y');
        if (count($lastNum) > 0) {
            $lastNum = $lastNum[0]->reference_devis;
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
        $save = Devis::create([
            'reference_devis' => $reference,
            'disponibilite' => $request->disponibilite,
            'validite' => $request->validite,
            'garentie' => $request->garentie,
//            'condition' => $request->condition,
            'objet' => $request->objet,
            'echeance' => $date,
            'condition_financiere' => $request->condition,
            'date_devis' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->idproduit); $i++) {
            Pocedes::create([
                'iddevis' => $save->devis_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' => $request->tva[$i],
                'remise' => $request->remise[$i],
                'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        if (isset($request->idproduit_com) and !empty($request->idproduit_com)) {
            for ($i = 0; $i < count($request->idproduit_com); $i++) {
                Complements::create([
                    'iddevis' => $save->devis_id,
                    'quantite' => $request->quantite_com[$i],
                    'prix' => $request->prix_com[$i],
                    'tva' => $request->tva_com[$i],
                    'remise' => $request->remise_com[$i],
                    'idproduit' => $request->idproduit_com[$i],
                    'iduser' => $iduser,
                ]);
            }
        }

        if ($save) {
            return redirect()->route('devis.all')->with('success', 'Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function viewDetail($id)
    {
        return 'In process';
    }

    public function showEditForm($id)
    {
        $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
            ->join('users', 'users.id', 'devis.iduser')
            ->where('devis_id', $id)
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
        $categories = Categories::whereIn('categorie_id',$ID )->orderBy('categories.created_at', 'desc')->get();
        $clients = Clients::orderBy('created_at', 'desc')->get();
        $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $id)->get();
        $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $id)->get();
        return view('devis.edit',compact('data','categories','complements','pocedes','clients','produits'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            'validite' => ['required'],
            'disponibilite' => ['required'],
            'devis_id' => ['required'],
        ]);


        $iduser = Auth::user()->id;
        $date = new DateTime($request->date);
//        $date->sub(new DateInterval('P1D'));
        $nbjour = $request->validite * 7;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

//        dd($reference); updateOrCreate
        $save = Devis::where('devis_id',$request->devis_id)->update([
            'disponibilite' => $request->disponibilite,
            'validite' => $request->validite,
            'garentie' => $request->garentie,
            'objet' => $request->objet,
            'echeance' => $date,
            'condition_financiere' => $request->condition,
            'date_devis' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->idproduit); $i++) {
            $pocedeId = '';
            if (isset($request->pocede_id[$i]) && !empty($request->pocede_id[$i])) {
                $pocedeId = $request->pocede_id[$i];
            }
            Pocedes::updateOrCreate(['pocede_id'=>$pocedeId],[
                'iddevis' => $request->devis_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' => $request->tva[$i],
                'remise' => $request->remise[$i],
                'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        if (isset($request->idproduit_com) and !empty($request->idproduit_com)) {

            for ($i = 0; $i < count($request->idproduit_com); $i++) {
                $complement_id ='';
                if (isset($request->complement_id[$i]) && !empty($request->complement_id[$i])) {
                    $complement_id = $request->complement_id[$i];
                }
                Complements::updateOrCreate(['complement_id'=>$pocedeId],[
                    'iddevis' => $request->devis_id,
                    'quantite' => $request->quantite_com[$i],
                    'prix' => $request->prix_com[$i],
                    'tva' => $request->tva_com[$i],
                    'remise' => $request->remise_com[$i],
                    'idproduit' => $request->idproduit_com[$i],
                    'iduser' => $iduser,
                ]);
            }
        }

        if ($save) {
            return redirect()->route('devis.all')->with('success', 'Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function removeProduit(Request $request){
        $request->validate([
            'id'=>['required']
        ]);
        $remove = Pocedes::where('pocede_id',$request->id)->delete();
        return Response()->json($remove);
    }
    public function removeComplement(Request $request) {
        $request->validate([
            'id'=>['required']
        ]);
        $remove = Complements::where('complement_id',$request->id)->delete();
        return Response()->json($remove);
    }


    public function delete(Request $request)
    {
        Pocedes::where('iddevis', $request->id)->delete();
        Paiements::where('iddevis', $request->id)->delete();
        Complements::where('iddevis', $request->id)->delete();
        $delete = Devis::where('devis_id', $request->id)->delete();
        return Response()->json($delete);
    }

    public function getDetails($id)
    {
        return 'in process';
    }

    public function validerDevis(Request $request)
    {
        $statut = Devis::where('devis_id', $request->id)->update(['statut' => 1]);
        return Response()->json($statut);
    }

    public function bloquerDevis(Request $request)
    {
        $statut = Devis::where('devis_id', $request->id)->update(['statut' => 0]);
        return Response()->json($statut);
    }

    public function makeFacture(Request $request)
    {
        return " In process";
    }

    public function printDevis($id)
    {
        $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
            ->join('users', 'users.id', 'devis.iduser')
            ->where('devis_id', $id)
            ->get()
        ;
        $date = new DateTime($data[0]->date_devis);
        $date = $date->format('m');

        $mois = (new \App\Models\Month)->getFrenshMonth((int)$date);
        $categories = Categories::all();
        $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $id)->get();
        $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $id)->get();
        $pdf = PDF::loadView('devis.print', compact('data', 'mois','categories', 'pocedes', 'complements'))->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($data[0]->reference_devis . '_' .date("d-m-Y H:i:s") . '.pdf');
    }


}
