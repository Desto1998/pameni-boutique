<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Images;
use App\Models\Produits;
use Illuminate\Http\Request;

class BoutiqueController extends Controller
{
    //
    public function index()
    {
        $produits = Produits::join('categories', 'categories.idcat', 'produits.idcat')->orderBy('produits.created_at', 'desc')->get();
        $categories = Categories::all();
        $images = Images::all();
        return view('site.botique', compact('produits', 'categories', 'images'));
    }

    public function detailProduit($id)
    {
        $product = Produits::join('categories', 'categories.idcat', 'produits.idcat')->where('id', $id)->orderBy('produits.created_at', 'desc')->get();
        $categories = Categories::all();
        $categorie = Categories::where('idcat', $product[0]->idcat)->get();
        $produits = Produits::join('categories', 'categories.idcat', 'produits.idcat')->where('produits.idcat', $product[0]->idcat)->orderBy('produits.created_at', 'desc')->get();
        $images = Images::where('idp',$id)->get();
        return view('site.detail', compact('produits', 'product', 'categories', 'images','categorie'));
    }

    public function boutique()
    {
        $categories = Categories::all();
        $produits = Produits::join('categories', 'categories.idcat', 'produits.idcat')->orderBy('produits.created_at', 'desc')->get();
        $images = Images::all();
        return view('site.botique', compact('produits', 'categories', 'images'));
    }

    public function categorie($id)
    {
        $categories = Categories::all();
        $categorie = Categories::where('idcat',$id)->get();
        $produits = Produits::where('produits.idcat', $id)->join('categories', 'categories.idcat', 'produits.idcat')->orderBy('produits.created_at', 'desc')->get();
        $images = Images::all();
        return view('site.categorie', compact('produits', 'categorie','categories', 'images'));
    }

    public function addToCard($id)
    {
        $produit = Produits::join('categories', 'categories.idcat', 'produits.idcat')->where('id', $id)->get();
        $itemArray = array($produit[0]->id => array('id' => $produit[0]->id, 'nom' => $produit[0]->nom, 'prix' => $produit[0]->prix, 'image' => $produit[0]->image, 'qte' => 1, 'description' => $produit[0]->description));
        $data = session("panier");
        if (isset($data) && !empty($data)) {
            $exist = false;

            foreach ($data as $key => $value) {
                # code...

                if ($produit[0]->id == $data[$key]["id"]) {
                    if (empty($data[$key]["qte"])){
                        $data[$key]["qte"] = 0;
                    }
                    $data[$key]["qte"] ++;
                    $exist = true;
                    session(['panier'=> null]);
                    session(['panier' => $data]);
//                    return session('panier')[$key]["qte"];
                }

            }
            if ($exist==false) {
                $data = array_merge($data, $itemArray);
                session(['panier'=> null]);
                session(['panier' => $data]);
            }
        } else {
            $data = $itemArray;
            session(['panier' => $data]);
//            $_SESSION["panier"] = $itemArray;
        }
//        session(['USERMENU' => $data]);
        return redirect()->back()->with('success', "Votre produit a été ajouté au panier avec succès!");
    }

    public function removeFromCard($id)
    {
        $data = session("panier");
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                # code...
                if ($id == $data[$key]["id"]) {

                    unset($data[$key]);
                    session(['panier' => $data]);
                }
                if (empty($data)) {
                    unset($data[$key]);
                    session(['panier' => $data]);
                }

            }

        }
        return redirect()->route('site.home');
    }

    public function removeAllCard()
    {
        session(['panier' => null]);
//        $_SESSION["panier"] = null;
        return redirect()->route('site.home');
    }

    public function totalCartFromCard($id)
    {
        $data = session("panier");
        $total = 0;
        if (!empty($data)) {
//        $target_dir = "../../assets/images/";
            foreach ($data as $key => $value) {
                $total += $data[$key]["prix"] * $data[$key]["qte"];
            }
        }
        return $total;
    }

    public function card()
    {
        return view('site.panier');
    }

    public function showCheckout()
    {
        return view('site.commande');
    }

    public function paiement(){
        return view('site.paiement');
    }
}
