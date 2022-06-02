<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Complements;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Pays;
use App\Models\Pieces;
use App\Models\Pocedes;
use App\Models\Produit_Factures;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Element;

class DiversController extends Controller
{
    //
    public function showAddFormProformat()
    {

        $pays = Pays::orderBy('nom_pays', 'asc')->get();

        $clients = Clients::orderBy('created_at', 'desc')->get();
        return view('divers.proformat.add', compact('clients', 'pays'));
    }

    public function storeProformat(Request $request) {
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            'validite' => ['required'],
            'titre' => ['required'],
            'disponibilite' => ['required'],
        ]);
//        dd($request);
//        $lastNum = Devis::whereYear('created_at', date('Y'))->ma('devis_id')->get() ;
        $lastNum = Devis::whereYear('created_at', date('Y'))
            ->whereRaw('devis_id = (select max(`devis_id`) from devis)')
            ->get();

        $iduser = Auth::user()->id;
        $date = new DateTime($request->date);
//        $date->sub(new DateInterval('P1D'));
        $nbjour = $request->validite * 7;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        /** @var 'on' genere la  $reference */
        $reference = 'PF' . date('Y');
        if (count($lastNum) > 0) {
            $lastNum = $lastNum[0]->reference_devis;
            $actual = 0;
            for ($j = 0; $j < strlen($lastNum); $j++) {
                if ($j > 5) {
                    $actual .= $lastNum[$j];
                }
            }
            $num = (int)$actual;
            $num += 1;
            $actual = str_pad($num, 3, "0", STR_PAD_LEFT);
            $reference .= $actual;
        } else {
            $num = 1;
            $actual = str_pad($num, 3, "0", STR_PAD_LEFT);
            $reference .= $actual;
        }
//        dd($reference);
        $save = Devis::create([
            'reference_devis' => $reference,
            'disponibilite' => $request->disponibilite,
            'validite' => $request->validite,
            'garentie' => $request->garentie,
//            'condition' => $request->condition,
            'objet' => $request->objet,
            'echeance' => $date,
            'condition_financiere' => $request->condition,
            'date_devis' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
            'type_devis' => 2,
        ]);

        for ($i = 0; $i < count($request->titre); $i++) {
            $pocedes = Pocedes::whereRaw('pocede_id = (select max(`pocede_id`) from pocedes)')->get();
            if (count($pocedes)>0) {
                $num = $pocedes[0]->pocede_id+1;
            }else{
                $num = 1;
            }
            $ref = "GSCDP-".$save->devis_id.''.$num;
            Pocedes::create([
                'reference_pocede' => $ref,
                'titre_pocede' => $request->titre[$i],
                'description_pocede' => $request->description[$i] ?? '',
                'iddevis' => $save->devis_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' =>  0 ,//$request->tva[$i],
                'remise' => $request->remise[$i] ?? '',
                // 'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        if (isset($request->titre_com) and !empty($request->titre_com)) {
            for ($i = 0; $i < count($request->titre_com); $i++) {
                Complements::create([
                    'titre_com' => $request->titre_com[$i],
                    'description_com' => $request->description_com[$i] ?? '',
                    'iddevis' => $save->devis_id,
                    'quantite' => $request->quantite_com[$i],
                    'prix' => $request->prix_com[$i],
                    'tva' => 0, //$request->tva_com[$i],
                    'remise' => $request->remise_com[$i] ?? '',
                   // 'idproduit' => $request->idproduit_com[$i],
                    'iduser' => $iduser,
                ]);
            }
        }

        if ($save) {
            return redirect()->route('devis.all')->with('success', 'Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }

    public function updateProformat(Request $request){
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            'validite' => ['required'],
            'disponibilite' => ['required'],
            'devis_id' => ['required'],
        ]);


        $iduser = Auth::user()->id;
        $date = new DateTime($request->date);
//        $date->sub(new DateInterval('P1D'));
        $nbjour = $request->validite * 7;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

//        dd($reference); updateOrCreate
        $save = Devis::where('devis_id',$request->devis_id)->update([
            'disponibilite' => $request->disponibilite,
            'validite' => $request->validite,
            'garentie' => $request->garentie,
            'objet' => $request->objet,
            'echeance' => $date,
            'condition_financiere' => $request->condition,
            'date_devis' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->titre); $i++) {
            $pocedeId = '';
            $ref = "";
            if (isset($request->pocede_id[$i]) && !empty($request->pocede_id[$i])) {
                $pocedeId = $request->pocede_id[$i];
            }else{
                $pocedes = Pocedes::whereRaw('pocede_id = (select max(`pocede_id`) from pocedes)')->get();
                if (count($pocedes)>0) {
                    $num = $pocedes[0]->pocede_id+1;
                }else{
                    $num = 1;
                }
                $ref = "GSCDP-".$request->devis_id.''.$num;
            }
            $ref = $request->ref[$i] ?? $ref;
            Pocedes::updateOrCreate(['pocede_id'=>$pocedeId],[
                'reference_pocede' => $ref,
                'titre_pocede' => $request->titre[$i],
                'description_pocede' => $request->description[$i] ?? '',
                'iddevis' => $request->devis_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' =>  0 ,//$request->tva[$i],
                'remise' => $request->remise[$i] ?? '',
                // 'idproduit' => $request->idproduit[$i],
                'iduser' => $iduser,
            ]);
        }
        if (isset($request->titre_com) and !empty($request->titre_com)) {
            for ($i = 0; $i < count($request->titre_com); $i++) {
                $complement_id ='';
                if (isset($request->complement_id[$i]) && !empty($request->complement_id[$i])) {
                    $complement_id = $request->complement_id[$i];
                }
                Complements::updateOrCreate(['complement_id'=>$complement_id],[
                    'titre_com' => $request->titre_com[$i],
                    'description_com' => $request->description_com[$i] ?? '',
                    'iddevis' => $request->devis_id,
                    'quantite' => $request->quantite_com[$i],
                    'prix' => $request->prix_com[$i],
                    'tva' => 0, //$request->tva_com[$i],
                    'remise' => $request->remise_com[$i] ?? '',
                    // 'idproduit' => $request->idproduit_com[$i],
                    'iduser' => $iduser,
                ]);
            }
        }

        if ($save) {
            return redirect()->route('devis.all')->with('success', 'Enregistré avec succès!');

        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }
    public function showAddFormFacture()
    {

        $pays = Pays::orderBy('nom_pays', 'asc')->get();

        $clients = Clients::orderBy('created_at', 'desc')->get();
        return view('divers.fact.add', compact('clients', 'pays'));
    }

    public function storeFacture(Request $request) {
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            'titre' => ['required'],
        ]);
//        dd($request);
//        $lastNum = Devis::whereYear('created_at', date('Y'))->ma('devis_id')->get() ;
        $lastNum = Factures::whereYear('created_at', date('Y'))
            ->whereRaw('facture_id = (select max(`facture_id`) from factures)')
            ->get();
        /** @var 'on' genere la  $reference */
        $reference = 'F' . date('Y');
        if (count($lastNum) > 0) {
            $lastNum = $lastNum[0]->reference_fact;
            $actual = 0;
            for ($j = 0; $j < strlen($lastNum); $j++) {
                if ($j > 5) {
                    $actual .= $lastNum[$j];
                }
            }
            $num = (int)$actual;
            $num += 1;
            $actual = str_pad($num, 3, "0", STR_PAD_LEFT);
            $reference .= $actual;
        } else {
            $num = 1;
            $actual = str_pad($num, 3, "0", STR_PAD_LEFT);
            $reference .= $actual;
        }
//        dd($reference);
        $iduser = Auth::user()->id;
        $save = Factures::create([
            'reference_fact' => $reference,
            'disponibilite' => $request->disponibilite,
            'garentie' => $request->garentie,
            'objet' => $request->objet,
            'condition_financiere' => $request->condition,
            'date_fact' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
            'type_fact' => 2,
        ]);

        for ($i = 0; $i < count($request->titre); $i++) {
            $pocedes = Produit_Factures::whereRaw('produit_f_id = (select max(`produit_f_id`) from produit_factures)')->get();
            if (count($pocedes)>0) {
                $num = $pocedes[0]->produit_f_id+1;
            }else{
                $num = 1;
            }
            $ref = "GSCDPF-".$save->facture_id.''.$num;
            Produit_Factures::create([
                'reference_pf' => $ref,
                'titre_pf' => $request->titre[$i],
                'description_pf' => $request->description[$i] ?? '',
                'idfacture' => $save->facture_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' => 0, //$request->tva[$i],
                'remise' => $request->remise[$i] ?? 0,
                'iduser' => $iduser,
            ]);
        }
        // On enregistre les infos du bon de commande
        if (isset($request->ref_bon)) {
            $file = $request->file('logo');
            $destinationPath = 'images/piece';
            $originalFile = "";
            if ($file) {
                $originalFile = $file->getClientOriginalName();
                $file->move($destinationPath, $originalFile);
            }
            Pieces::create([
                'chemin' => $originalFile,
                'ref' => $request->ref_bon,
                'date_piece' => $request->date_bon,
                'idfacture' => $save->facture_id,
                'iduser' => $iduser,
            ]);
        }
        if ($save) {
            return redirect()->route('factures.all')->with('success', 'Enregistré avec succès!');
        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }


    public function updateFacture(Request $request){
        $request->validate([
            'date' => ['required'],
            'objet' => ['required', 'min:5'],
            'quantite' => ['required'],
            'prix' => ['required'],
            'facture_id' => ['required'],
        ]);

        $iduser = Auth::user()->id;
        $date = new DateTime($request->date);
//        $date->sub(new DateInterval('P1D'));
        $nbjour = $request->validite * 7;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));

//        dd($reference); updateOrCreate
        $save = Factures::where('facture_id', $request->facture_id)->update([
            'objet' => $request->objet,
            'date_fact' => $request->date,
            'idclient' => $request->idclient,
            'tva_statut' => $request->tva_statut,
            'iduser' => $iduser,
        ]);
        for ($i = 0; $i < count($request->titre); $i++) {
            $pocedeId = '';
            $ref = "";
            if (isset($request->produit_f_id[$i]) && !empty($request->produit_f_id[$i])) {
                $pocedeId = $request->produit_f_id[$i];
            }else{
                $pocedes = Produit_Factures::whereRaw('produit_f_id = (select max(`produit_f_id`) from produit_factures)')->get();
                if (count($pocedes)>0) {
                    $num = $pocedes[0]->produit_f_id+1;
                }else{
                    $num = 1;
                }
                $ref = "GSCDPF-".$request->facture_id.''.$num;
            }
            $ref = $request->ref[$i] ?? $ref;

            Produit_Factures::updateOrCreate(['produit_f_id' => $pocedeId], [
                'reference_pf' => $ref,
                'titre_pf' => $request->titre[$i],
                'description_pf' => $request->description[$i] ?? '',
                'idfacture' => $request->facture_id,
                'quantite' => $request->quantite[$i],
                'prix' => $request->prix[$i],
                'tva' => 0, //$request->tva[$i],
                'remise' => $request->remise[$i] ?? 0,
                'iduser' => $iduser,
            ]);
        }
        if (isset($request->ref_bon)) {
            $file = $request->file('logo');
            $destinationPath = 'images/piece';
            $originalFile = "";
            if ($file) {
                $originalFile = $file->getClientOriginalName();
                $file->move($destinationPath, $originalFile);
            } else {
                $originalFile = $request->chemin;
            }
            Pieces::updateOrCreate(['piece_id' => $request->piece_id], [
                'chemin' => $originalFile,
                'ref' => $request->ref_bon,
                'date_piece' => $request->date_bon,
                'idfacture' => $request->facture_id,
                'iduser' => $iduser,
            ]);
        }
        /** on modifie le statut de son devis et on met a 1. Pour que ca reste a valide
         * au lieu de facture creee
         **/
        $fact = Factures::where('facture_id', $request->facture_id)->get();
        if (count($fact) > 0) {
            if (isset($fact[0]->iddevis) && !empty($fact[0]->iddevis)) {
                Devis::where('devis_id', $fact[0]->iddevis)->update(['statut' => 1]);

            }
        }
        if ($save) {
            return redirect()->route('factures.all')->with('success', 'Enregistré avec succès!');
        }
        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");
    }
}
