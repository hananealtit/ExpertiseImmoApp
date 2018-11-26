<?php

namespace App\Http\Controllers;

use App\Jugement;
use Illuminate\Http\Request;

class JugementController extends Controller
{
    // enregistrer le nb de procureurs et de defendeurs

    public function saveNB(Request $request){

        var_dump($request->all());
        $jugement=Jugement::where('num_jugement',$request->num_jugement)->where('dossiers_num_dossier',$request->num_dossier)->where('tribunals_id_tribunal',$request->num_idtribunal);
        $jugement->update([
            'nbr_procureur'=>$request->nbr_procureur,
            'nbr_defendeur'=>$request->nbr_defendeur,
            'nbr_autres'=>$request->nbr_autres,
            'nbr_immobilier'=>$request->nbr_immobilier

        ]);
//        $jugement->nbr_immobilier=$request->nbr_immobilier;
//        $jugement->update();

    }
}
