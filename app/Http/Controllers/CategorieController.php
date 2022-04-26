<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CategorieController extends Controller
{
    //
    //function for product categories
    public function listCategories()
    {
//        $data = Categories::join('users', 'users.id', 'categories.iduser')->get();
        return view('categorie.index');
    }

    //create new categorie or update if id is provided
    public function storeCategorie(Request $request)
    {
        $request->validate([
            'code_cat' => ['required', 'min:3', 'string'],
            'titre_cat' => ['required', 'min:3', 'string'],
        ]);
        $iduser = Auth::user()->id;
        $dataId = $request->categorie_id;
        $checkCode = Categories::where('categorie_id','!=',$dataId)
            //->where('titre_cat',$request->titre_cat)
            ->where('code_cat', $request->code_cat)->get();
        if (count($checkCode) > 0) {
//            return redirect()->back()->with('warning', 'Une catégorie avec ce code existe déja!');
            $statut = 0;
            // retourne 0 si une categorie existe deja avec ce code
            return  Response()->json($statut);
        }

        $save = Categories::updateOrCreate(
            ['categorie_id' => $dataId],
            [
                'titre_cat' => $request->titre_cat,
                'code_cat' => strtoupper($request->code_cat),
                'description_cat' => $request->description_cat,
                'iduser' => $iduser,

            ]);
        return Response()->json($save);
//        if ($save) {
//            return redirect()->back()->with('success', 'Enregistré avec succès!');
//
//        }
//        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    //delete categorie
    public function deleteCategore(Request $request)
    {
//        Produits::where('idcategorie',$request->id)->delete();
        $delete = Categories::where('categorie_id', $request->id)->delete();
        return Response()->json($delete);
    }
    // charge les categorie sur le datatable
    public function loadCategorie() {
        if (request()->ajax()) {

            $data = Categories::join('users', 'users.id', 'categories.iduser')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($value){
                    $action = view('categorie.action',compact('value'));

//                    $actionBtn = '<div class="d-flex"><a href="javascript:void(0)" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm ml-1"  onclick="deleteFun()"><i class="fa fa-trash"></i></a></div>';
                    return (string)$action;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
    }
}
