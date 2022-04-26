<?php

namespace App\Http\Controllers;

use App\Models\Commentaires;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    //Ajouter un commentaire pour une facture
    public function addCommentFacture(Request $request)
    {
        $request->validate([
            'idfacture' => ['required'],
            'message' => ['required'],
        ]);

        $iduser = Auth::user()->id;
        $dataID = $request->commentaire_id;
        $save = Commentaires::updateOrCreate(['commentaire_id'=>$dataID],
            [
                'idfacture' => $request->idfacture,
                'message' => $request->message,
                'statut_commentaire' => 1,
                'iduser' => $iduser,
                'date_commentaire' => date('Y-m-d'),
            ])
        ;
        if ($save) {
            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }

    //Ajouter un commentaire pour un devis
    public function addCommentDevis(Request $request)
    {
        $request->validate([
            'iddevis' => ['required'],
            'message' => ['required'],
        ]);
        $iduser = Auth::user()->id;
        $dataID = $request->commentaire_id;
        $save = Commentaires::updateOrCreate(['commentaire_id'=>$dataID],
            [
                'iddevis' => $request->iddevis,
                'message' => $request->message,
                'statut_commentaire' => 1,
                'date_commentaire' => date('Y-m-d'),
                'iduser' => $iduser,
            ])
        ;
        if ($save) {
            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }

    //Ajouter un commentaire pour une commande
    public function addCommentCommande(Request $request)
    {
        $request->validate([
            'idcommande' => ['required'],
            'message' => ['required'],
        ]);
        $iduser = Auth::user()->id;
        $dataID = $request->commentaire_id;
        $save = Commentaires::updateOrCreate(['commentaire_id'=>$dataID],
            [
                'idcommande' => $request->idcommande,
                'message' => $request->message,
                'statut_commentaire' => 1,
                'date_commentaire' => date('Y-m-d'),
                'iduser' => $iduser,
            ])
        ;
        if ($save) {
            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }
    //Ajouter un commentaire pour une bon de livraison
    public function addCommentBon(Request $request)
    {
        $request->validate([
            'idbonlivraison' => ['required'],
            'message' => ['required'],
        ]);
        $iduser = Auth::user()->id;
        $dataID = $request->commentaire_id;
        $save = Commentaires::updateOrCreate(['commentaire_id'=>$dataID],
            [
                'idbonlivraison' => $request->idbonlivraison,
                'message' => $request->message,
                'statut_commentaire' => 1,
                'date_commentaire' => date('Y-m-d'),
                'iduser' => $iduser,
            ])
        ;
        if ($save) {
            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }
    //Ajouter un commentaire pour facture avoir
    public function addCommentAvoir(Request $request)
    {
        $request->validate([
            'idavoir' => ['required'],
            'message' => ['required'],
        ]);
        $iduser = Auth::user()->id;
        $dataID = $request->commentaire_id;
        $save = Commentaires::updateOrCreate(['commentaire_id'=>$dataID],
            [
                'idavoir' => $request->idavoir,
                'message' => $request->message,
                'statut_commentaire' => 1,
                'date_commentaire' => date('Y-m-d'),
                'iduser' => $iduser,
            ])
        ;
        if ($save) {
            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }

    //Ajouter un commentaire pour une commande
    public function updateComment(Request $request)
    {
        $request->validate([
            'commentaire_id' => ['required'],
            'message' => ['required'],
        ]);
        $dataID = $request->commentaire_id;
        $save = Commentaires::updateOrCreate(['commentaire_id'=>$dataID],
            [
                'message' => $request->message,
                'statut_commentaire' => 1,
            ])
        ;
        if ($save) {
            return redirect()->back()->with('success', 'enregistrés avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

    }
    public function deleteComment(Request $request){
        $delete = Commentaires::where('commentaire_id',$request->id)->delete();
        return Response()->json($delete);
    }
}
