<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Complements;
use App\Models\Devis;
use App\Models\Paiements;
use App\Models\Pocedes;
use App\Models\Produits;
use App\Models\User;
use DateInterval;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\DateTime;
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

    public function loadDevis() {
        $data = Devis::join('clients', 'clients.client_id', 'devis.idclient')
            ->orderBy('devis.created_at', 'desc')
            ->get();
        $users = User::all();
        $complements = Complements::all();
        $pocedes = Pocedes::all();
        $paiements = Paiements::all();
        $product  = new Array_();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($value) {
                $categories = Categories::all();
                $users = User::all();
                $complements = Complements::all();
                $pocedes = Pocedes::all();
                $paiements = Paiements::all();
                $action = view('devis.action', compact('value', 'categories'));

//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                return (string)$action;
            })
//                ->addColumn('action', 'produit_action')
            ->rawColumns(['action'])
            ->make(true)
            ;
    }
    public function showAddForm()
    {
        $produits = Produits::orderBy('created_at', 'desc')->get();
        $categories = Categories::join('produits', 'produits.idcategorie', 'categories.categorie_id')->orderBy('categories.created_at', 'desc')->get();
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
        $date->add(new DateInterval("P{$request->validite}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

        $reference = 'PF'.date('Y');
        if (count($lastNum)>0) {
            $lastNum = $lastNum[0]->reference_devis;
            $actual = 0;
            for ($j=0;$j<strlen($lastNum);$j++){
                if ($j>5) {
                    $actual .=$lastNum[$j] ;
                }

            }
            $num = (int)$actual;
            $num +=1;
            $actual = str_pad($num, 3, "0", STR_PAD_LEFT);
            $reference .= $actual;
        }else{
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
            'condition' => $request->condition,
            'objet' => $request->objet,
            'echeance' => $date,
            'condition_financiere' => $request->condition,
            'date_devis' => $request->date,
            'idclient' => $request->idclient,
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
        return "in process";
    }

    public function edit(Request $request)
    {
        return $request;
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
}
