<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Produits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $data = Categories::all();
        return view('admin.categorie.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $request->validate([
                    'titre_cat' => ['required', 'min:3', 'string'],
                ]);
                $iduser = Auth::user()->id;
                $dataId = $request->categorie_id;
                $checkCode = Categories::where('idcat','!=',$dataId)
                    //->where('titre_cat',$request->titre_cat)
                    ->where('titre', $request->titre_cat)->get();
                if (count($checkCode) > 0) {
                    return redirect()->back()->with('warning', 'Une catégorie avec ce titre existe déja!');

                    // retourne 0 si une categorie existe deja avec ce code
//                    return  Response()->json($statut);
                }

                $save = Categories::updateOrCreate(
                    ['idcat' => $dataId],
                    [
                        'titre' => $request->titre_cat,
                        'description_cat' => $request->description_cat,

                    ]);

                if ($save) {
                    return redirect()->back()->with('success', 'Enregistré avec succès!');

                }
                return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $categories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     *
     */
    public function destroy(Request $request)
    {
        Produits::where('idcat',$request->id)->delete();
        $delete = Categories::where('idcat', $request->id)->delete();
        return Response()->json($delete);
    }

    public function delete(Request $request)
    {
        Produits::where('idcat',$request->id)->delete();
        $delete = Categories::where('idcat', $request->id)->delete();
        return Response()->json($delete);
    }
}
