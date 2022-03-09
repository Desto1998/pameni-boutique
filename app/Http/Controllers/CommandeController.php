<?php

namespace App\Http\Controllers;

use App\Models\Complements;
use App\Models\Devis;
use App\Models\Paiements;
use App\Models\Pocedes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    //\
    public function index(){
        return "in proccess";
//        $data = Devis::join('clients','clients.client_id','devis.idclient')
//            ->orderBy('devis.created_at','desc' )
//            ->get()
//        ;
//        $users = User::all();
//        $complements = Complements::all();
//        $pocedes = Pocedes::all();
//        $paiements= Paiements::all();
//        return view('devis.index',
//            compact('data','users','complements','paiements','pocedes')
//        );

    }
    public function showAddForm(){
        return "in proccess";
        return view('devis.create');
    }

    public function store(Request $request)
    {
        $iduser = Auth::user()->id;
        return 'in process';
    }

    public function viewDetail($id)
    {
        return 'In process';
    }
    public function showEditForm($id){
        return "in process";
    }
    public function edit(Request  $request){
        return $request;
    }
    public function delete(Request $request){
        Pocedes::where('iddevis',$request->id)->delete();
        Paiements::where('iddevis',$request->id)->delete();
        Complements::where('iddevis',$request->id)->delete();
        $delete  = Devis::where('devis_id',$request->id)->delete();
        return Response()->json($delete);
    }

    public function getDetails($id){
        return 'in process';
    }
}
