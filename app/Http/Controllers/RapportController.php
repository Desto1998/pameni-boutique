<?php

namespace App\Http\Controllers;

use App\Models\Charges;
use App\Models\Taches;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class RapportController extends Controller
{
    //Show charge form
    protected function showChargeForm(){
        $charges = Charges::all();
        return view('rapport.charge_form',compact('charges'));
    }

    // Make pdf for charge
    protected function printCharge(Request $request){
        $request->validate([
           'debut'=>['required'],
           'fin'=>['required'],
           'charge'=>['required']
        ]);
        $titre = $request->titre;
        $debut = $request->debut;
        $fin = $request->fin;
        if ($request->charge==0) {
            $data = Taches::join('charges','charges.charge_id','taches.idcharge')
                ->where('date_debut','<=',$request->fin)
                ->where('date_debut','>=',$request->debut)
                ->orderBy('taches.date_ajout','desc' )
                ->get()
            ;
        }else{
            $data = Taches::where('date_debut','<=',$request->fin)
                ->where('date_debut','>=',$request->debut)
                ->where('tache_id',$request->charge)
                ->join('charges','charges.charge_id','taches.idchage')
                ->orderBy('taches.date_ajout','desc' )
                ->get();
            ;
        }
        $charges = Charges::all();
        $users= User::all();
        $mois = (new \App\Models\Month)->getFrenshMonth((int)date('m'));
        $pdf = PDF::loadView('rapport.print_charge',
            compact('users','titre','charges','data','debut','mois','fin'))->setPaper('a4', 'landscape')->setWarnings(false);

//                $pdf->download('Rapport_des_charge_du'.$request->jour);

        return $pdf->stream('Rapport_des_charges_du' . $request->debut . '_au_' . $request->fin . '.pdf');
    }
}
