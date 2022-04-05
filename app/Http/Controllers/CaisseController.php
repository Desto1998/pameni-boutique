<?php

namespace App\Http\Controllers;

use App\Models\Caisses;
use App\Models\Entrees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CaisseController extends Controller
{
    public function index(){
        return view('caisses.index');
    }
    //
    public function loadCaisses(Request $request){
        if ($request->ajax()) {
            $data =Caisses::join('users','users.id','caisses.iduser')->orderBy('caisses.created_at','desc' )->get();
            return Datatables::of($data)
                ->addIndexColumn()
//                ->addColumn('type', function($value){
//                    $type = '<span class="text-primary">Charge variable</span>';
//                    if ($value->type_charge==1) {
//                        $type = '<span class="text-success"> Charge fixe</span>';
//                    }
////                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
//                    return $type;
//                })
                ->addColumn('action', function($value){
                    $action = view('caisses.action',compact('value'));

//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                    return (string)$action;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return false;
    }

    public function storeCaisse($data){
        $iduser = Auth::user()->id;
        switch ($data->key){
            case 'PAIEMENT':
                $save = Caisses::updateOrCreate(
                    ['idpaiement' => $data->id],
                    [
                        'raison' => $data->raison,
                        'montant' => $data->montant,
                        'description' => $data->description,
                        'date_depot' => date('Y-m-d'),
                        'type_operation' => 1,
                        'iduser' => $iduser,
                        'idpaiement' => $data->id,
                    ])
                ;
            break;
            case 'TACHE':
                $save = Caisses::updateOrCreate(
                    ['idtache' => $data->id],
                    [
                        'raison' => $data->raison,
                        'montant' => $data->montant,
                        'description' => $data->description,
                        'date_depot' => date('Y-m-d'),
                        'type_operation' => 1,
                        'iduser' => $iduser,
                        'idtache' => $data->id,
                    ])
                ;
            break;
            default:
                $save = Caisses::updateOrCreate(
                    ['identre' => $data->id],
                    [
                        'raison' => $data->raison,
                        'montant' => $data->montant,
                        'description' => $data->description,
                        'date_depot' => date('Y-m-d'),
                        'type_operation' => 0,
                        'identre' => $data->id,
                        'iduser' => $iduser,

                    ])
                ;
        }
        return $save;
    }
}
