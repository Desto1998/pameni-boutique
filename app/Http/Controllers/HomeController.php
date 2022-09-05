<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commandes;
use App\Models\Images;
use App\Models\Produits;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comET = Commandes::where('statut',0)->get();
        $comEC = Commandes::where('statut',1)->get();
        $comT = Commandes::where('statut',2)->get();
        $clients = Clients::all();
       return view('dashboard',compact('clients','comEC','comET','comT'));
    }
    public function home(){
        return view('welcome');
    }
    public function site()
    {
        $produits = Produits::orderBy('id','desc')->get();
        $categories = Categories::all();
        $images = Images::all();
       return view('site.index',compact('produits','categories','images'));
    }
    public function boutique()
    {
        $produits = Produits::orderBy('id','desc')->get();
        $categories = Categories::all();
        $images = Images::all();
       return view('site.botique',compact('produits','categories','images'));
    }
    public function categorie($id)
    {
        $produits = Produits::orderBy('id','desc')->get();
        $categories = Categories::all();
        $images = Images::all();
       return view('site.categorie',compact('produits','categories','images'));
    }
    public function detail($id)
    {
        $produits = Produits::orderBy('id','desc')->get();
        $categories = Categories::all();
        $images = Images::all();
       return view('site.detail',compact('produits','categories','images'));
    }

    public function text()
    {
        return redirect(route('home'))->with('warning','Un bon test reuissi toujours!');
    }
    public function paiement(){
        return view('site.paiement');
    }

}
