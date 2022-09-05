<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Images;
use App\Models\Produits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $data = Produits::orderBy('id','desc')->get();
        $categories = Categories::all();
        return view('admin.produit.index',compact('categories','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        $categories = Categories::all();
        return view('admin.produit.creer',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'min:3', 'string'],
            'idcat' => ['required'],
            'quantite' => ['required'],
            'prix' => ['required'],
        ]);
        $iduser = Auth::user()->id;
        $dataId = $request->id;

        $save = Produits::updateOrCreate(
            ['id' => $dataId],
            [
                'nom' => $request->nom,
                'description' => $request->description,
                'prix' => $request->prix,
                'quantite' => $request->quantite,
                'image' => $request->image[0],
                'idcat' => $request->idcat,
            ]);
            for($i=0; $i<count($request->image); $i++){
                Images::create(
                    ['idp'=>$save->id,'chemin'=>$request->image[$i]]
                );
            }
        if ($save) {
            return redirect()->route('produits.index')->with('success', 'Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produits  $produits
     * @return \Illuminate\Http\Response
     */
    public function show(Produits $produits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produits  $produits
     *
     */
    public function edit($id)
    {
        $product = Produits::where('id',$id)->get();
        $categories = Categories::all();
        $images = Images::where('idp',$id)->get();
        return view('admin.produit.edit',compact('product','categories','images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     *
     */
    public function update(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'min:3', 'string'],
            'idcat' => ['required'],
            'quantite' => ['required'],
            'prix' => ['required'],
        ]);
        $iduser = Auth::user()->id;
        $dataId = $request->id;

        $save = Produits::updateOrCreate(
            ['id' => $dataId],
            [
                'nom' => $request->nom,
                'description' => $request->description,
                'prix' => $request->prix,
                'quantite' => $request->quantite,
                'image' => $request->image[0],
                'idcat' => $request->idcat,
            ]);
        Images::where('idp',$request->id)->delete();
        for($i=0; $i<count($request->image); $i++){
            Images::create(
                ['idp'=>$save->id,'chemin'=>$request->image[$i]]
            );
        }
        if ($save) {
            return redirect()->route('produits.index')->with('success', 'Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produits  $produits
     *
     */
    public function destroy(Request $request)
    {
        Images::where('idp',$request->id)->delete();
        $delete = Produits::where('id', $request->id)->delete();
        return Response()->json($delete);
    }
    public function delete(Request $request)
    {
        Images::where('idp',$request->id)->delete();
        $delete = Produits::where('id', $request->id)->delete();
        return Response()->json($delete);
    }
}
