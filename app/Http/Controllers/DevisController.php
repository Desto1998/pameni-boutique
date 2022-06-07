<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commentaires;
use App\Models\Complements;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Month;
use App\Models\Paiements;
use App\Models\Pays;
use App\Models\Pieces;
use App\Models\Pocedes;
use App\Models\Produit_Factures;
use App\Models\Produits;
use App\Models\User;
use DateInterval;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use DateTime;
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

    public function loadDevis($id)
    {
        if ($id<=0) {
            $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                ->join('users', 'users.id', 'devis.iduser')
                ->orderBy('devis.created_at', 'desc')
                ->get();
        }else{
            $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
                ->join('users', 'users.id', 'devis.iduser')
                ->where('devis.idclient',$id)
                ->orderBy('devis.created_at', 'desc')
                ->get();
        }


//        $product  = new Array_();
        return Datatables::of($data)
            ->addIndexColumn()
            //Ajoute de la colonne action
            ->addColumn('action', function ($value) {
                $categories = Categories::all();
                if ($value->type_devis==2) {
                    $pocedes = Pocedes::where('iddevis', $value->devis_id)->get();
                    $complements = Complements::where('iddevis', $value->devis_id)->get();

                }else {
                    $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $value->devis_id)->get();
                    $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $value->devis_id)->get();

                }
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
                } elseif ($value->statut == 1){
                    $statut = '<span class="text-primary">Validé</span>';
                } else {
                    $statut = '<span class="text-success">Facture créée</span>';
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
                }elseif ($value->tva_statut == 2){
                    $montantTTC = (($montantTVA * 5.5) / 100) + $montantTVA;
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
        $pays = Pays::orderBy('nom_pays','asc')->get();
        $categories = Categories::whereIn('categorie_id',$ID )->orderBy('categories.created_at', 'desc')->get();

        $clients = Clients::orderBy('created_at', 'desc')->get();
        return view('devis.create', compact('categories', 'produits', 'clients','pays'));
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
        /** @var 'on' genere la  $reference */
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
                'tva' =>  0 ,//$request->tva[$i],
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
                    'tva' => 0, //$request->tva_com[$i],
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
        $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
        ->join('users', 'users.id', 'devis.iduser')
        ->where('devis_id', $id)
        ->get()
    ;
        if ($data[0]->type_devis==2) {
            $pocedes = Pocedes::where('iddevis', $data[0]->devis_id)->get();
            $complements = Complements::where('iddevis', $data[0]->devis_id)->get();

        }else {
            $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $data[0]->devis_id)->get();
            $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $data[0]->devis_id)->get();

        }
//        $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $id)->get();
//        $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $id)->get();
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

        if ($data[0]->tva_statut == 1) {
            $montantTTC = (($montantTVA * 19.25) / 100) + $montantTVA;
        }elseif ($data[0]->tva_statut == 2){
            $montantTTC = (($montantTVA * 5.5) / 100) + $montantTVA;
        }else{
            $montantTTC = $montantTVA;
        }
        $montantTTC= number_format($montantTTC, 2, '.', '');
        $montantTVA= number_format($montantTVA, 2, '.', '');
        $montant= number_format($montant, 2, '.', '');
        $commentaires = Commentaires::join('users','users.id','commentaires.iduser')->where('iddevis',$id)->get();

//        $piece = Pieces::where('i', $id)->get();
        return view('devis.details.index', compact('data','pocedes','montant',
            'montantTTC','montantTVA','commentaires','complements')) ;
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
        if ($data[0]->type_devis==2) {
            $pocedes = Pocedes::where('iddevis', $data[0]->devis_id)->get();
            $complements = Complements::where('iddevis', $data[0]->devis_id)->get();
            return view('divers.proformat.edit',compact('data','categories','complements','pocedes','clients','produits'));

        }else {
            $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $data[0]->devis_id)->get();
            $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $data[0]->devis_id)->get();
            return view('devis.edit',compact('data','categories','complements','pocedes','clients','produits'));

        }
//        $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $id)->get();
//        $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $id)->get();
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
                'tva' => 0, //$request->tva[$i],
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
                Complements::updateOrCreate(['complement_id'=>$complement_id],[
                    'iddevis' => $request->devis_id,
                    'quantite' => $request->quantite_com[$i],
                    'prix' => $request->prix_com[$i],
                    'tva' =>0, // $request->tva_com[$i],
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
        $request->validate([
            'ref_bon' => ['required'],
            'date_bon' => ['required'],
            'iddevis' => ['required'],
        ]);
        $devis = Devis::where('devis_id',$request->iddevis)->get();
        $iduser = Auth::user()->id;
        /** @var 'on' genere la  $reference */
        $lastNum = Factures::whereYear('created_at', date('Y'))
            ->whereRaw('facture_id = (select max(`facture_id`) from factures)')
            ->get()
        ;

        if ($devis[0]->type_devis==2) {
            $pocedes = Pocedes::where('iddevis', $devis->devis_id)->get();
        }else {
            $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $request->iddevis)->get();

        }
//        $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $request->iddevis)->get();
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
        if ($devis[0]) {
            $save = Factures::create([
                'reference_fact' => $reference,
                'disponibilite' => $devis[0]->disponibilite,
                'garentie' => $devis[0]->garentie,
                'objet' => $devis[0]->objet,
                'condition_financiere' => $devis[0]->condition,
                'date_fact' => $request->date,
                'idclient' => $devis[0]->idclient,
                'tva_statut' => $devis[0]->tva_statut,
                'iduser' => $iduser,
                'iddevis' => $request->iddevis,
                'type_fact' => $devis[0]->type_devis,
            ]);
            if ($save) {
                foreach ($pocedes as $key=>$p) {
                    Produit_Factures::create([
                        'idfacture' => $save->facture_id,
                        'quantite' => $p->quantite,
                        'prix' => $p->prix,
                        'tva' => $p->tva,
                        'remise' => $p->remise,
                        'idproduit' => $p->idproduit,
                        'iduser' => $iduser,
                        'reference_pf' => $p->reference_pocede,
                        'titre_pf' => $p->titre_pocede,
                        'description_pf' => $p->description_pocede,
                    ]);
                }
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
                    'idfacture' => $save->facture_id,
                    'iduser' => $iduser,
                ]);
            }
        }
        $statut = Devis::where('devis_id', $request->iddevis)->update(['statut' => 2]);
        return Response()->json($save);
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
        if ($data[0]->type_devis==2) {
            $pocedes = Pocedes::where('iddevis', $data[0]->devis_id)->get();
            $complements = Complements::where('iddevis', $data[0]->devis_id)->get();

        }else {
            $complements = Complements::join('produits', 'produits.produit_id', 'complements.idproduit')->where('iddevis', $id)->get();
            $pocedes = Pocedes::join('produits', 'produits.produit_id', 'pocedes.idproduit')->where('iddevis', $id)->get();
        }

        $pdf = PDF::loadView('devis.print', compact('data', 'mois','categories', 'pocedes', 'complements'))->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($data[0]->reference_devis . '_' .date("d-m-Y H:i:s") . '.pdf');
    }


}
