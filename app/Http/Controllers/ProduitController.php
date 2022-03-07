<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Produits;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    //function for product categories
    public function listCategories(){
        $data = Categories::join('users','users.id','categories.iduser')->get();
        return view('produit.categorie',compact('data'));
    }
    //create new categorie or update if id is provided
    public function storeCategorie(Request $request){
        $request->validate([
           'code_cat'=>['required','min:3','string'] ,
           'titre_cat'=>['required','min:3','string'] ,
        ]);
        $iduser = Auth::user()->id;
        $dataId = $request->categorie_id;
        $checkCode = Categories::where('code_cat',$request->code_cat)->get();
        if (count($checkCode)>0) {
            return redirect()->back()->with('warning','Une catégorie avec ce code existe déja!');
        }

        $save  = Categories::updateOrCreate(
            ['categorie_id' => $dataId],
            [
                'titre_cat' => $request->titre_cat,
                'code_cat' => $request->code_cat,
                'description_cat' => $request->description_cat,
                'iduser' => $iduser,

            ])
        ;
        if ($save) {
            return redirect()->back()->with('success','Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }
    //delete categorie
    public function deleteCategore(Request $request){
//        Produits::where('idcategorie',$request->id)->delete();
        $delete = Categories::where('categorie_id',$request->id)->delete();
        return Response()->json($delete);
    }

    //function for pruducts
    public function listproduct(Request $request){
        $data = Produits::join('categories','categories.categorie_id','produits.idcategorie')
            ->join('users','users.id','produits.iduser')
            ->orderBy('produits.created_at','desc' )
            ->get()
        ;
        $categories = Categories::all();
        return view('produit.produit',compact('data','categories'));
    }
    //function create or update product
    public function storeProduct(Request $request){
        $request->validate([
            'titre_produit'=>['required','min:3','string'] ,
            'idcategorie'=>['required'] ,
        ]);
        $iduser = Auth::user()->id;
        $dataId = $request->produit_id;
        $getcat = Categories::where('categorie_id',$request->idcategorie)->get();

        $reference = '';
        if (isset($request->reference)) {
           $reference = $request->reference;
        }else {
            $generatecode = Produits::where('idcategorie',$request->idcategorie)
                ->whereRaw('produit_id = (select max(`produit_id`) from produits)')
                ->get();

            if (count($generatecode)>0) {
                $input = $generatecode[0]->reference;
                $from = strlen($input)-4;

//                $from = $from - strlen($input);
                $actual = '';

                for ($i=$from; $i<strlen($input);$i++)
                {
                    $actual .= $input[$i];
                }
                $actual =(int)$actual;
                $actual+=1;
                $input = $getcat[0]->code_cat;
                $reference = str_pad($actual, 4, "0", STR_PAD_LEFT);
                $reference = $input. $reference;
            }else{
                $input = $getcat[0]->code_cat;
                $reference = str_pad('1', 4, "0", STR_PAD_LEFT);
                $reference = $input. $reference;
            }
//            $code = str_pad($input, 4, "0", STR_PAD_LEFT);
//            $code = $letter . '-' . $code;
        }
        $save  = Produits::updateOrCreate(
            ['produit_id' => $dataId],
            [
                'titre_produit' => $request->titre_produit,
                'idcategorie' => $request->idcategorie,
                'reference' => $reference,
                'description_produit' => $request->description_produit,
                'iduser' => $iduser,

            ])
        ;
        if ($save) {
            return redirect()->back()->with('success','Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    //delete product
    public function deleteProduct(Request $request){
        $delete = Produits::where('produit_id',$request->id)->delete();
        return Response()->json($delete);
    }
}
