<?php

namespace App\Http\Controllers;

use App\Models\Paiements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    //
    public function updatePaiement(Request $request)
    {
        $request->validate([
            'montant' => ['required'],
            'mode' => ['required'],
            'idfacture' => ['required'],
        ]);
        $dataID = $request->paiement_id;
        $iduser = Auth::user()->id;
        $save = Paiements::updateOrCreate(['paiement_id' => $dataID], [
            'idfacture' => $request->idfacture,
            'mode' => $request->mode,
            'montant' => $request->montant,
            'description' => $request->description,
            'date_paiement' => date('Y-m-d'),
            'statut' => 1,
            'iduser' => $iduser,
        ]);
        if ($save) {
            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");


    }
}
