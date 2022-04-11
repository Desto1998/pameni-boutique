<?php

namespace App\Http\Controllers;

use App\Models\Paiements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

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
        if ($request->oldmode == "Espèce" && $request->mode != "Espèce") {

            $d = (new CaisseController())->removeFromCaisse($dataID, 'PAIEMENT');
        }
        if ($save) {
            if ($request->mode == "Espèce") {
                $factData = new Array_();
                $factData->key = 'PAIEMENT';
                $factData->raison = 'Versement pour facture';
                $factData->montant = $request->montant;
                $factData->description = $request->description;
                if ($dataID > 0) {
                    $factData->id = $dataID;
                } else {
                    $factData->id = $save->paiement_id;
                }

                if ((new CaisseController())->storeCaisse($factData)) {
                    $statut = 2;
                }
            }

            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");


    }
}
