<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Factures;
use App\Models\Log_factures;
use App\Models\Log_P_Factures;
use App\Models\Produit_Factures;
use App\Models\User;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //
    public function index(){
        $logs = Log_factures::where('log_statut','<',3)->orderBy('created_at', 'desc')->get();
        $logproducts = Log_P_Factures::join('produits','produits.produit_id','log_p_factures.log_idproduit')->get();
        $factproduct = Produit_Factures::join('produits','produits.produit_id','produit_factures.idproduit')->get();
        $factures = Factures::whereRaw('facture_id in(select log_idfacture from log_factures where log_statut <3)')
            ->orderBy('created_at', 'desc')
            ->get()
        ;
        $users = User::all();
        $client = Clients::all();
        return view('facture.historique',compact('logproducts','logs','factures','factproduct','users','client'));
    }
    protected function archivate(Request $request){
        $statut = Log_factures::where('log_f_id', $request->id)->update(['log_statut' => 3]);
        return Response()->json($statut);
    }
    public function delete(Request $request)
    {
        Log_P_Factures::where('log_idf', $request->id)->delete();
        $delete = Log_factures::where('log_f_id', $request->id)->delete();
        return Response()->json($delete);
    }
}
