<?php

namespace App\Http\Controllers;

use App\Arrivant;
use App\Defendeur;
use App\Defendeurs_immobiliers;
use App\Dossier;
use App\Immobilier;
use App\Immobiliers_natures;
use App\Jugement;
use App\Jugements_defendeurs;
use App\Jugements_procureurs;
use App\Procureur;
use App\Procureurs_immobiliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class ImmobiliersController extends Controller
{


    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

// fonction pour ajouter un immobilier
   public function store(Request $request)
    {

       try {
           $validator = Validator::make($request->all(), [
               'num_immobilier' => 'required|unique:immobiliers',
               'adresse_immobilier' => 'required|max:255',
               'designation_immobilier' => 'required|max:255',
               'ville_immobilier' => 'required'
           ]);

           if ($validator->fails()) {
               return Response::json(array(
                   'success' => false,
                   'errors' => $validator->getMessageBag()->toArray()

               ), 400);
           }else{
               $immobilier = new Immobilier();
               $immobilier->num_immobilier = $request->num_immobilier;
               $immobilier->designation_immobilier = $request->designation_immobilier;
               $immobilier->adresse_immobilier = strip_tags($request->adresse_immobilier);
               $immobilier->ville = $request->ville_immobilier;
               $immobilier->jugements_num_jugement = $request->num_jugement;
               $immobilier->jugements_dossiers_num_dossier = $request->num_dossier;
               $immobilier->jugements_tribunals_id_tribunal = $request->num_idtribunal;
               $immobilier->surface = $request->surface;
               $execute=$immobilier->save();
               return new JsonResponse(['data' => $execute], 200);
           }
       }catch(\Exception $e){
           return Response::json(array(
               'success' => false,
               'errors' => $e

           ), 400);
       }
//
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
   //
       public function gImmobilier(){
        $dossiers=Dossier::where('deposer','0')->paginate(5);
        $jugements='';
        $immobiliers='';
        $a=[];
        foreach ($dossiers as $k=>$dossier) {
            $jugement = Jugement::where('dossiers_num_dossier', $dossier->num_dossier)->first();
            if(!empty($jugement)) {
                $immobiliers = Immobilier::where('jugements_num_jugement', $jugement->num_jugement)->get();
//            $a[$k][]=$dossier->num_dossier;
                foreach ($immobiliers as $immobilier) {
                    $a[$dossier->num_dossier][] = $immobilier->num_immobilier;
                }
            }

        }
            return view('admin.g_immobilier',compact('a','dossiers'));
    }
    public function pourcentagePropriete($id){
        $a=[];
        $immobilier = Immobilier::where('num_immobilier', $id)->first();
        $num_dossier=$immobilier->jugements_dossiers_num_dossier;
        $jugements_procureurs=Jugements_procureurs::where('jugements_num_jugement',$immobilier->jugements_num_jugement)->get();
        $k=0;
        foreach ($jugements_procureurs as $jugements_procureur){
            $procureur_immobilier=Procureurs_immobiliers::where('id_procureur',$jugements_procureur->procureurs_id_procureur)->where('id_immobilier',$immobilier->num_immobilier)->first();
               if(!empty($procureur_immobilier)) {
                   $procureur = Procureur::where('id_procureur', $procureur_immobilier->id_procureur)->first();

                   if (!empty($procureur)) {
                       $a[$k][] = $immobilier->num_immobilier;
                       $a[$k][] = $procureur_immobilier->id_procureur;
                       $a[$k][] = $jugements_procureur->jugements_dossiers_num_dossier;
                       $a[$k][] = 'pr';
                       if (!empty($procureur_immobilier)) {
                           $a[$k][] = $procureur_immobilier->pourcentage;
                       } else {
                           $a[$k][] = null;
                       }
                       $a[$k][] = $procureur->nom_procureur;
//                dd($a);
                       $k++;
                   }
               }


        }

        $jugements_defendeurs=Jugements_defendeurs::where('jugements_num_jugement',$immobilier->jugements_num_jugement)->get();
        foreach ($jugements_defendeurs as $jugements_defendeur) {
            $defendeur_immobilier = Defendeurs_immobiliers::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->where('id_immobilier', $immobilier->num_immobilier)->first();
            if (!empty($defendeur_immobilier)) {
                $defendeur = Defendeur::where('id_defendeur', $defendeur_immobilier->id_defendeur)->first();
                if (!empty($defendeur)) {
                    $a[$k][] = $immobilier->num_immobilier;
                    $a[$k][] = $defendeur->id_defendeur;
                    $a[$k][] = $jugements_defendeur->jugements_dossiers_num_dossier;
                    $a[$k][] = 'def';
                    if (!empty($defendeur_immobilier)) {
                        $a[$k][] = $defendeur_immobilier->pourcentage;
                    } else {
                        $a[$k][] = null;
                    }
                    $a[$k][] = $defendeur->nom_defendeur;
                    $k++;
                }
            }
        }
        $array=Session::get('p');
        $array_arrs=[];
        if(count($array)>0) {
            foreach ($array as $table) {
                if ($table[0]['table'] == 'arr') {
                    $array_arrs[] = $table[0];
                }
            }
        }
        $arrivants=Arrivant::where('id_immobilier',$immobilier->num_immobilier)->get();
        if(Session::has('p')) {
            if (count($array_arrs) > 0) {
                foreach ($array_arrs as $array_arr) {
                    $a[$k][] = $array_arr['num_immobilier'];;
                    $a[$k][] = $array_arr['partie'];
                    $a[$k][] = $array_arr['num_dossier'];;
                    $a[$k][] = 'arr';
                    $a[$k][] = $array_arr['pourcentage'];
                    $a[$k][] = $array_arr['partie'];
                    $k++;

                }
            }
        }else{
            foreach ($arrivants as $arrivant) {
                $a[$k][] = $arrivant->id_immobilier;;
                $a[$k][] = $arrivant->id_arrivant;
                $a[$k][] = $num_dossier;
                $a[$k][] = 'arr';
                $a[$k][] = $arrivant->pourcentage;
                $a[$k][] = $arrivant->nom_arrivant;
                $k++;
            }
        }
//        dd(Session::get('p'));
        if(Session::get('p')!=null) {
            foreach (Session::get('p') as $vle) {
                foreach ($a as $i => $t) {
                    if($vle[0]['table']!='arr') {
                        if ($t[1] == $vle[0]['partie'] && $t[3] == $vle[0]['table']) {
                            $a[$i][4] = $vle[0]['pourcentage'];
                        }
                    }
                }
//
            }
        }

//        die();
        return view('admin.pourcentagePr',compact('a','id','num_dossier'));
    }
   public function validerPr(Request $request){
        $somme=0;
        $racine=[];
        if(isset($request->all()['a'])) {
            $id = $request->all()['a'][0][0];
            $nd = $request->all()['a'][0][2];
            foreach ($request->all()['a'] as $k => $vl) {
                if (isset($vl[4])) {
                    $racine = explode('/', $vl[4]);
                    if (isset($racine[1])) {
                        $somme = ($racine[0] / $racine[1]) + $somme;

                    } else {
                        $somme = ($racine[0]) + $somme;

                    }
                }

            }
           

           $delta=$somme-1;
            if($delta<=0.09){
                $somme=1;
            }

            if (abs(($somme - 1) / $somme) > 0.00001) {
                return redirect()->route('immobiliers.pourcentagePropriete', [$id, $nd])->with('danger', 'يجب أن يكون المجموع يساوي 1');

            } else if (abs(($somme - 1) / $somme) < 0.00001) {

                foreach ($request->all()['a'] as $k => $vl) {

                    if (isset($vl[4])) {
                        if ($vl[3] == 'pr') {
                            DB::table('procureurs_immobiliers')->where('id_procureur', $vl[1])->where('id_immobilier', $vl[0])->update(['pourcentage' => $vl[4]]);;

                        }
                        if ($vl[3] == 'def') {
                            DB::table('defendeurs_immobiliers')->where('id_defendeur', $vl[1])->where('id_immobilier', $vl[0])->update(['pourcentage' => $vl[4]]);;

                        }
                        if ($vl[3] == 'arr') {

                            $arrivants=Arrivant::where('id_arrivant', $vl[1])->where('id_immobilier', $vl[0])->first();
                            if(!empty($arrivants)){
                            DB::table('arrivants')->where('id_arrivant', $vl[1])->where('id_immobilier', $vl[0])->update(['pourcentage' => $vl[4]]);;
                            }else{
                                $arrivant = new Arrivant();
                                $arrivant->nom_arrivant = $vl[5];
                                $arrivant->pourcentage = $vl[4];
                                $arrivant->id_immobilier = $vl[0];
                                $arrivant->save();
                            }

                        }
//

                    }

                }
                Session::forget('p');
                return redirect()->route('immobiliers.pourcentagePropriete', [$id, $nd])->with('success', 'تمت الإضافة بنجاح');


            } else {

                return redirect()->route('immobiliers.pourcentagePropriete', [$id, $nd])->with('danger', 'يجب أن يكون المجموع يساوي 1');


            }
        }else{
            return back();

        }
    }
public function gImages(){
        $immobiliers=Immobilier::all();

        return view('admin.gestionImages',compact('immobiliers'));
    }
  public function add_images(Request $request){

        $this->validate($request, [
            // check validtion for image or file
            'image_satellite' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'image_map' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        $getimagesatellite = time().random_int(0,5).'.'.$request->image_satellite->getClientOriginalExtension();
        $getimagemap = time().random_int(0,5).'.'.$request->image_map->getClientOriginalExtension();
        DB::table('immobiliers')->where('num_immobilier',$request->num_immobilier)->update(['img_satellite'=>$getimagesatellite]);
        DB::table('immobiliers')->where('num_immobilier',$request->num_immobilier)->update(['img_map'=>$getimagemap]);
        $path_satellite=rtrim(public_path(),'public').'scripts/uploads/satellite/';
        $path_maps=rtrim(public_path(),'public').'scripts/uploads/maps/';
        $request->image_satellite->move($path_satellite, $getimagesatellite);
        $request->image_map->move($path_maps, $getimagemap);
        return back()
            ->with('success','.تمت إضافة الصور بنجاح');
    }
}
