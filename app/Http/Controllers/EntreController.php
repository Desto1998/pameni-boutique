<?php

namespace App\Http\Controllers;

use App\Models\Entrees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class EntreController extends Controller
{
    public function index(){
        return view('gestion.entrees');
    }
    //On charge les encaissements dans le tableau
    public function loadEntree(){
        if (request()->ajax()) {

            $data =Entrees::join('users','users.id','entrees.iduser')->orderBy('entrees.created_at','desc' )->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($value){
                    $action = view('gestion.entree_action',compact('value'));

//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                    return (string)$action;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return false;
    }
    protected function storeEntree(Request $request)
    {
        $request->validate([
            'raison' => ['required', 'string', 'min:3'],
            'montant' => ['required'],
        ]);
        $iduser = Auth::user()->id;
        $dataId = $request->entre_id;

        $save = Entrees::updateOrCreate(
            ['entre_id' => $dataId],
            [
                'raison_entre' => $request->raison,
                'montant_entre' => $request->montant,
                'description_entre' => $request->description,
                'date_entre' => date('Y-m-d'),
                'statut_entre' => 1,
                'iduser' => $iduser,

            ])
        ;
        return Response()->json($save);
    }
    protected function deleteEntree(Request $request){
        $delete = Entrees::where('entre_id',$request->id)->delete();
        return Response()->json($delete);
    }
}
