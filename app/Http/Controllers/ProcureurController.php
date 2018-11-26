<?php

namespace App\Http\Controllers;

use App\Arrivant;
use App\Avocat;
use App\Defendeurs_immobiliers;
use App\Dossier;
use App\Immobilier;
use App\Jugement;
use App\Jugements_defendeurs;
use App\Jugements_procureurs;
use App\Procureur;
use App\Procureurs_avocats;
use App\Procureurs_immobiliers;
use App\Procureursavocats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
class ProcureurController extends Controller
{
   public function index()
    {
        $dossiers=DB::table('dossiers')->paginate(10);
        return view('admin.panel_dossiers_procureur',compact('dossiers'));
    }
    public function administration($id){
        $jugement_prs=Jugements_procureurs::where('jugements_dossiers_num_dossier',$id)->get();
        $procureurs=[];
        foreach ($jugement_prs as $jugement_pr){
            $pr=Procureur::where('id_procureur',$jugement_pr->procureurs_id_procureur)->first();
            $procureurs[]=$pr;
        }
        return view('admin.gestion_procureur',compact('procureurs','id'));
    }

   public function create($id)
    {
        $avocat=Avocat::pluck('nom_avocat','id_avocat');
        $avocat['']='';
        return view('admin.add_procureur',compact('id','avocat'));
    }

// inserer un procureur
  public function store(Request $request)
    {

//            var_dump($request->all());
        try{
            $validator = Validator::make($request->all(), [
                'genre' => 'required',
                'nom_procureur' => 'required',
                'adresse_procureur' => 'required',
            ]);
            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400);
            } else {
                $procureur = new Procureur();
                $procureur->nom_procureur = $request->nom_procureur;
                $procureur->adresse_procureur = strip_tags($request->adresse_procureur);
                $procureur->nbr_avocat = $request->nbr_avocat;
                $procureur->genre = ($request->genre === 'true') ? 'F' : 'M';
                $procureur->save();
                $id_p = Procureur::latest('id_procureur')->first();
                $immobiliers = Immobilier::where('jugements_dossiers_num_dossier', $request->num_dossier)->get();
                foreach ($immobiliers->all() as $immobilier) {
                    $procureur_immobilier = new Procureurs_immobiliers();
                    $procureur_immobilier->id_procureur = $id_p->id_procureur;
                    $procureur_immobilier->id_immobilier = $immobilier->num_immobilier;
                    $procureur_immobilier->save();
                }
                $nbav = $request->nbr_avocat;
                for ($i = 0; $i < $nbav; $i++) {
                    if (!empty($request->genre_p[$i])) {
                        $procureur_avocat = new Procureurs_avocats();
                        $procureur_avocat->procureurs_id_procureur = $id_p->id_procureur;
                        $procureur_avocat->avocats_id_avocat = $request->genre_p[$i];
                        $procureur_avocat->save();
                    }
                }

                $jugement_procureur = new Jugements_procureurs();
                $jugement_procureur->jugements_num_jugement = $request->num_jugement;
                $jugement_procureur->jugements_dossiers_num_dossier = $request->num_dossier;
                $jugement_procureur->procureurs_id_procureur = $id_p->id_procureur;
                $execute = $jugement_procureur->save();
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
    
    public function create_procureur(Request $request){
        $rule=['nom_procureur'=>'required','adresse_procureur'=>'required'];
        if($request->isavocat=='نعم'){
            $rule['nom_avocat.*']='required';
            $rule['adresse_avocat.*']='required';
            $rule['ville_avocat.*']='required';
        }
        $this->validate($request,$rule);
        $procureur=new Procureur();
        $procureur->nom_procureur=$request->nom_procureur;
        $procureur->adresse_procureur=strip_tags($request->adresse_procureur);
        if(!empty($request->av_list)) {
            $procureur->nbr_avocat = count($request->av_list);
        }else if($request->isavocat=='نعم'){
            $procureur->nbr_avocat = count($request->nom_avocat);
        }
        $procureur->genre=($request->genre==='true')?'F':'M';
        $procureur->save();
        $id_p=Procureur::latest('id_procureur')->first();
        if (!empty($request->av_list)) {
            for ($i = 0; $i < count($request->av_list); $i++) {
                $procureur_avocat = new Procureurs_avocats();
                $procureur_avocat->procureurs_id_procureur = $id_p->id_procureur;
                $procureur_avocat->avocats_id_avocat =$request->av_list[$i];
                $procureur_avocat->save();
            }
        }
        else if($request->isavocat=='نعم'){
            $nbav=count($request->nom_avocat);
            for($i=0;$i<$nbav;$i++) {
                $avocat = new Avocat();
                $avocat->genre = $request->genre_p[$i];
                $avocat->nom_avocat = $request->nom_avocat[$i];
                $avocat->adresse_avocat = $request->adresse_avocat[$i];
                $avocat->ville = $request->ville_avocat[$i];
                $avocat->save();
                $last_av=Avocat::latest('id_avocat')->first();

                $procureur_avocat = new Procureurs_avocats();
                $procureur_avocat->procureurs_id_procureur = $id_p->id_procureur;
                $procureur_avocat->avocats_id_avocat = $last_av->id_avocat;
                $procureur_avocat->save();
            }
        }
        $immobiliers=Immobilier::where('jugements_dossiers_num_dossier',$request->num_dossier)->get();
        foreach ($immobiliers->all() as $immobilier) {
            $procureur_immobilier = new Procureurs_immobiliers();
            $procureur_immobilier->id_procureur = $id_p->id_procureur;
            $procureur_immobilier->id_immobilier = $immobilier->num_immobilier;
            $procureur_immobilier->save();
        }

        $jugement=Jugement::where('dossiers_num_dossier',$request->num_dossier)->first();
        $jugement_procureur=new Jugements_procureurs();
        $jugement_procureur->jugements_num_jugement=$jugement->num_jugement;
        $jugement_procureur->jugements_dossiers_num_dossier=$request->num_dossier;
        $jugement_procureur->procureurs_id_procureur=$id_p->id_procureur;
        $jugement_procureur->save();
        return redirect()->route('procureur.administration',$request->num_dossier)->with('success','تم التحفيض بنجاح.');
    }
    public function show($id)
    {
        //
    }

   public function destroy_pr($id){
        DB::table('procureurs_immobiliers')->where('id_procureur', $id)->delete();
        DB::table('jugements_procureurs')->where('procureurs_id_procureur', $id)->delete();
        DB::table('procureurs_avocats')->where('procureurs_id_procureur', $id)->delete();
        DB::table('procureurs')->where('id_procureur', $id)->delete();
        return back()->with('success','تم الحذف');
    }
    
  public function edit($id,$d)
    {
        $procureur=Procureur::where('id_procureur',$id)->first();
        return view('admin.edit_procureur',compact('procureur','d'));
    }


    public function update(Request $request, Procureur $procureur)
    {
        $this->validate($request,[
            'nom_procureur'=>'required',
            'adresse_procureur'=>'required',
            'nbr_avocat'=>'required',
            'present'=>'required',
            'genre'=>'required',

        ]);
        $procureur->nom_procureur=$request->nom_procureur;
        $procureur->adresse_procureur=$request->adresse_procureur;
        $procureur->nbr_avocat=$request->nbr_avocat;
        $procureur->present=$request->present;
        $procureur->genre=$request->genre;
        $procureur->update();
        return redirect()->route('procureur.administration',$request->num_dossier)->with('success','تم التحفيض بنجاح.');


    }

//  fonction pour supprimer
    public function delete(Request $request)
    {


//           DB::table('jugements_procureurs')->where('procureurs_id_procureur',$request->partie)->where('jugements_dossiers_num_dossier',$request->num_dossier)->delete();
        if($request->table=='pr') {
            DB::table('procureurs_immobiliers')->where('id_procureur', $request->partie)->where('id_immobilier', $request->num_immobilier)->delete();
        }if($request->table=='def'){
        DB::table('defendeurs_immobiliers')->where('id_defendeur',$request->partie)->where('id_immobilier',$request->num_immobilier)->delete();

    } if($request->table=='arr'){
        DB::table('arrivants')->where('nom_arrivant',$request->nom_arrivant)->where('id_immobilier',$request->num_immobilier)->delete();

    }

        return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier])->with('success','تم الحذف بنجاح');

    }
//  fonction pour ajouter des pourcentage
       public function addpourcentage(Request $request){

       Session::push('p',[$request->all()]);


        return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier]);
       }
//       ajouter des nouveaux arrivants
       public function add_procureur(Request $request){

            Session::push('p',[$request->all()]);
           return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier]);

       }
//       supprimer l'arrivant
       public function deleteArr(Request $request){

           DB::table('arrivants')->where('id_immobilier',$request->num_immobilier)->where('nom_arrivant','like','%'.$request->nom_arrivant.'%')->delete();


           return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier])->with('success','تم الحذف بنجاح');

       }
//       fonction pour modifier la table procureurs_immobiliers et defendeurs_immobiliers et arrivants
       public function modifier(Request $request){
//
           $array = Session::get('p');
           if ($request->session()->has('p')) {
               foreach (Session::get('p') as $k => $table) {
                   if ($table[0]['partie'] == $request->partie && $table[0]['num_immobilier'] == $request->num_immobilier) {
                       $array[$k][0]['pourcentage'] = $request->pr;
                   }
               }


               $request->session()->put('p', $array);
               return redirect()->route('immobiliers.pourcentagePropriete', [$request->num_immobilier, $request->num_dossier])->with('success', 'تم التحديث بنجاح');

           }else{
               $pi=Procureurs_immobiliers::where('id_immobilier',$request->num_immobilier)->get();
               $di=Defendeurs_immobiliers::where('id_immobilier',$request->num_immobilier)->get();
               $arr=Arrivant::where('id_immobilier',$request->num_immobilier)->get();
               foreach ($pi as $j=>$i){
                   if($i->id_procureur==$request->partie && $i->id_immobilier==$request->num_immobilier){
                       $pi[$j]->pourcentage=$request->pr;
                   }
               }
               foreach ($di as $j=>$i){
                   if($i->id_defendeur==$request->partie && $i->id_immobilier==$request->num_immobilier){
                       $di[$j]->pourcentage=$request->pr;
                   }
               }

               foreach ($arr as $j=>$i){
                   if($i->id_arrivant==$request->partie && $i->id_immobilier==$request->num_immobilier){
                       $arr[$j]->pourcentage=$request->pr;
                   }
               }

               $somme_pi=0;
               $somme_di=0;
               $somme_arr=0;
               foreach ($pi->all() as $item){
                   if($item->pourcentage!=null) {
                       $r = explode('/', $item->pourcentage);
                       $racin_pi = $r[0] / $r[1];
                       $somme_pi = $racin_pi + $somme_pi;
                   }
               }
               foreach ($di->all() as $item){
                   if($item->pourcentage!=null) {
                       $r = explode('/', $item->pourcentage);
                       $racin_di = $r[0] / $r[1];
                       $somme_di = $racin_di + $somme_di;
                   }
               }
               foreach ($arr->all() as $item){
                   if($item->pourcentage!=null) {
                       $r = explode('/', $item->pourcentage);
                       $racin_arr = $r[0] / $r[1];
                       $somme_arr = $racin_arr + $somme_arr;
                   }
               }
               $s=0;
               if($request->pr!=null){
                   $s=$somme_pi+$somme_di+$somme_arr;
               }


               if(abs(($s-1)/$s)<0.00001) {
                   if ($request->table == 'pr') {
                       DB::table('procureurs_immobiliers')->where('id_procureur', $request->partie)->where('id_immobilier', $request->num_immobilier)->update(['pourcentage' => $request->pr]);;

                   }
                   if ($request->table == 'def') {
                       DB::table('defendeurs_immobiliers')->where('id_defendeur', $request->partie)->where('id_immobilier', $request->num_immobilier)->update(['pourcentage' => $request->pr]);;

                   }
                   if ($request->table == 'arr') {
                       DB::table('arrivants')->where('nom_arrivant', $request->nom_arrivant)->where('id_immobilier', $request->num_immobilier)->update(['pourcentage' => $request->pr]);;

                   }
                   return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier])->with('success','تم التحديث بنجاح');

               }else
               {
                   return redirect()->route('immobiliers.pourcentagePropriete',[$request->num_immobilier,$request->num_dossier])->with('danger','يجب أن يكون المجموع يساوي 1');

               }
               return redirect()->route('immobiliers.pourcentagePropriete', [$request->num_immobilier, $request->num_dossier]);

           }






//
       }
}
