<?php

namespace App\Http\Controllers;

use App\Avocat;
use App\Defendeur;
use App\Jugement;
use App\Defendeurs_avocats;
use App\Defendeurs_immobiliers;
use App\Immobilier;
use App\Jugements_defendeurs;
use App\Procureurs_immobiliers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DefendeurController extends Controller
{

    public function index()
    {
       $dossiers=DB::table('dossiers')->paginate(10);
        return view('admin.panel_dossiers_defendeur',compact('dossiers'));
    }
    public function administration($id){
        $jugement_defs=Jugements_defendeurs::where('jugements_dossiers_num_dossier',$id)->get();
        $defendeurs=[];
        foreach ($jugement_defs as $jugement_def){
            $def=Defendeur::where('id_defendeur',$jugement_def->defendeurs_id_defendeur)->first();
            $defendeurs[]=$def;
        }
        return view('admin.gestion_defendeur',compact('defendeurs','id'));
    }
   public function create($id)
    {
        $avocat=Avocat::pluck('nom_avocat','id_avocat');
        $avocat['']='';
        return view('admin.add_defendeur',compact('id','avocat'));
    }
  public function create_defendeur(Request $request){

        $rule=['nom_defendeur'=>'required','adresse_defendeur'=>'required'];
        if($request->isavocat=='نعم'){
            $rule['nom_avocat.*']='required';
            $rule['adresse_avocat.*']='required';
            $rule['ville_avocat.*']='required';
        }
//        dd($rule);
        $this->validate($request,$rule);

        $defendeur=new Defendeur();
        $defendeur->nom_defendeur=$request->nom_defendeur;
        $defendeur->adresse_defendeur=strip_tags($request->adresse_defendeur);
        if(!empty($request->av_list)){
            $defendeur->nbr_avocat=count($request->av_list);
        }else if($request->isavocat=='نعم'){
            $defendeur->nbr_avocat=count($request->nom_avocat);
        }
        $defendeur->genre=($request->genre==='true')?'F':'M';
        $defendeur->save();
        $id_d=Defendeur::latest('id_defendeur')->first();
            if (!empty($request->av_list)) {
                for($i=0;$i<count($request->av_list);$i++) {
                    $defendeur_avocat = new Defendeurs_avocats();
                    $defendeur_avocat->defendeurs_id_defendeur = $id_d->id_defendeur;
                    $defendeur_avocat->avocats_id_avocat = $request->av_list[$i];
                    $defendeur_avocat->save();
                }
            }
        else if($request->isavocat=='نعم'){
            $nbav=count($request->nom_avocat);
            for($i=0;$i<$nbav;$i++) {
                $avocat = new Avocat();
                $avocat->genre = $request->genre_d[$i];
                $avocat->nom_avocat = $request->nom_avocat[$i];
                $avocat->adresse_avocat = $request->adresse_avocat[$i];
                $avocat->ville = $request->ville_avocat[$i];
                $avocat->save();
                $last_av=Avocat::latest('id_avocat')->first();

                $defendeur_avocat = new Defendeurs_avocats();
                $defendeur_avocat->defendeurs_id_defendeur = $id_d->id_defendeur;
                $defendeur_avocat->avocats_id_avocat = $last_av->id_avocat;
                $defendeur_avocat->save();
            }
        }
        $immobiliers=Immobilier::where('jugements_dossiers_num_dossier',$request->num_dossier)->get();
        foreach ($immobiliers as $immobilier) {
            $defendeur_immobilier = new Defendeurs_immobiliers();
            $defendeur_immobilier->id_defendeur = $id_d->id_defendeur;
            $defendeur_immobilier->id_immobilier = $immobilier->num_immobilier;
            $defendeur_immobilier->save();
        }
        $jugement=Jugement::where('dossiers_num_dossier',$request->num_dossier)->first();
        $jugement_defendeur=new Jugements_defendeurs();
        $jugement_defendeur->jugements_num_jugement=$jugement->num_jugement;
        $jugement_defendeur->jugements_dossiers_num_dossier=$request->num_dossier;
        $jugement_defendeur->defendeurs_id_defendeur=$id_d->id_defendeur;
        $jugement_defendeur->save();
        return redirect()->route('defendeur.administration',$request->num_dossier)->with('success','تم التحفيض بنجاح.');
    }
//  fonction ajouter des defendeur
   public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'genre'=>'required',
                'nom_defendeur' => 'required',
                'adresse_defendeur' => 'required',
            ]);
            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400);


            } else {
                $defendeur = new Defendeur();
                $defendeur->nom_defendeur = $request->nom_defendeur;
                $defendeur->adresse_defendeur = strip_tags($request->adresse_defendeur);
                $defendeur->nbr_avocat = $request->nbr_avocat;
                $defendeur->genre = ($request->genre === 'true') ? 'F' : 'M';
                $defendeur->save();
                $id_d = Defendeur::latest('id_defendeur')->first();
                $immobiliers = Immobilier::where('jugements_dossiers_num_dossier', $request->num_dossier)->get();
                foreach ($immobiliers as $immobilier) {
                    $defendeur_immobilier = new Defendeurs_immobiliers();
                    $defendeur_immobilier->id_defendeur = $id_d->id_defendeur;
                    $defendeur_immobilier->id_immobilier = $immobilier->num_immobilier;
                    $defendeur_immobilier->save();
                }
                $nbav = $request->nbr_avocat;
                for ($i = 0; $i < $nbav; $i++) {
                    if (!empty($request->genre_d[$i])) {
                        $defendeur_avocat = new Defendeurs_avocats();
                        $defendeur_avocat->defendeurs_id_defendeur = $id_d->id_defendeur;
                        $defendeur_avocat->avocats_id_avocat = $request->genre_d[$i];
                        $defendeur_avocat->save();
                    }
                }
                $jugement_defendeur = new Jugements_defendeurs();
                $jugement_defendeur->jugements_num_jugement = $request->num_jugement;
                $jugement_defendeur->jugements_dossiers_num_dossier = $request->num_dossier;
                $jugement_defendeur->defendeurs_id_defendeur = $id_d->id_defendeur;
                $execute = $jugement_defendeur->save();
                return new JsonResponse(['data' => $execute], 200);

            }
        }
        catch(\Exception $e){
            return Response::json(array(
                'success' => false,
                'errors' => $e

            ), 400);
        }
    }


    public function show($id)
    {
        //
    }

   public function destroy_def($id){
        DB::table('defendeurs_immobiliers')->where('id_defendeur', $id)->delete();
        DB::table('jugements_defendeurs')->where('defendeurs_id_defendeur', $id)->delete();
        DB::table('defendeurs_avocats')->where('defendeurs_id_defendeur', $id)->delete();
        DB::table('defendeurs')->where('id_defendeur', $id)->delete();
        return back()->with('success','تم الحذف');
    }
    
   public function edit($id,$d)
    {
        $defendeur=Defendeur::where('id_defendeur',$id)->first();
        return view('admin.edit_defendeur',compact('defendeur','d'));
    }

    public function delete(Request $request){
        dump($request->all());
        die();
        DB::table('defendeurs_immobiliers')->where('id_defendeur',$request->partie)->where('id_immobilier',$request->num_immobilier)->delete();


        return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier])->with('success','تم الحذف بنجاح');
    }

   public function update(Request $request, Defendeur $defendeur)
    {
        $this->validate($request,[
            'nom_defendeur'=>'required',
            'adresse_defendeur'=>'required',
            'nbr_avocat'=>'required',
            'present'=>'required',
            'genre'=>'required',

        ]);
        $defendeur->nom_defendeur=$request->nom_defendeur;
        $defendeur->adresse_defendeur=$request->adresse_defendeur;
        $defendeur->nbr_avocat=$request->nbr_avocat;
        $defendeur->present=$request->present;
        $defendeur->genre=$request->genre;
        $defendeur->update();
        return redirect()->route('defendeur.administration',$request->num_dossier)->with('success','تم التحفيض بنجاح.');


    }


    public function destroy($id)
    {
        //
    }
//    fonction pour ajouter
    public function addpourcentage(Request $request){
        Session::push('p',[$request->all()]);
        return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier]);
    }
}
