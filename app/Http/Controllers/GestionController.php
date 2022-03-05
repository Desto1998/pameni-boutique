<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\Charges;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class GestionController extends Controller
{
    //
    public function charge()
    {
        $charges = Charges::join('users','users.id','charges.iduser')->get();
        return view('gestion.charges', compact('charges'));
    }

    protected function storeCharge(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string', 'min:3',],
        ]);
        $iduser = Auth::user()->id;
        $dataId = $request->charge_id;
        $save = Charges::updateOrCreate(
            ['charge_id' => $dataId],
            [
                'titre' => $request->titre,
                'description' => $request->description,
                'iduser' => $iduser,

            ])
        ;
        return redirect()->back()->with('success','Enregistré avec succès!');

    }
    protected function deleteCharge(Request $request){
        $delete = Charges::where('charge_id',$request->id)->delete();
        return Response()->json($delete);
    }
}
