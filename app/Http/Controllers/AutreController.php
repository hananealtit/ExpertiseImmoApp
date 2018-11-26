<?php

namespace App\Http\Controllers;

use App\Autre;
use App\Jugements_autres;
use App\Jugement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class AutreController extends Controller
{

  public function index()
    {
        $dossiers=DB::table('dossiers')->paginate(10);
        return view('admin.panel_dossiers_autre',compact('dossiers'));
    }
   public function administration($id){
        $jugement_autres=Jugements_autres::where('jugements_dossiers_num_dossier',$id)->get();
        $autres=[];
        foreach ($jugement_autres as $jugement_autre){
            $a=Autre::where('id_autre',$jugement_autre->autres_id_autre)->first();
            $autres[]=$a;
        }
        return view('admin.gestion_autre',compact('autres','id'));
    }
    public function create($id)
    {
        return view('admin.add_autre',compact('id'));

    }
     public function create_autre(Request $request){
        $this->validate($request,[
            'description_autre'=>'required'
        ]);
        $autre=new Autre();
        $autre->description_autre=strip_tags($request->description_autre);
        $autre->save();
        $id_a=Autre::latest('id_autre')->first();
        $jugement=Jugement::where('dossiers_num_dossier',$request->num_dossier)->first();

        $jugement_autre=new Jugements_autres();
        $jugement_autre->jugements_num_jugement=$jugement->num_jugement;
        $jugement_autre->jugements_dossiers_num_dossier=$request->num_dossier;
        $jugement_autre->jugements_tribunals_id_tribunal=$jugement->tribunals_id_tribunal;
        $jugement_autre->autres_id_autre=$id_a->id_autre;
        $jugement_autre->save();
        return redirect()->route('autre.administration',$request->num_dossier)->with('success','تم التحفيض بنجاح.');

    }
    /**
     * ajout d'un conservateur 
     **/ 
   public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'description_autre' => 'required'
            ]);
            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400);


            } else {
                $autre = new Autre();
                $autre->description_autre = strip_tags($request->description_autre);
                $autre->save();
                $id_a = Autre::latest('id_autre')->first();
                $jugement_autre = new Jugements_autres();
                $jugement_autre->jugements_num_jugement = $request->num_jugement;
                $jugement_autre->jugements_dossiers_num_dossier = $request->num_dossier;
                $jugement_autre->jugements_tribunals_id_tribunal = $request->num_idtribunal;
                $jugement_autre->autres_id_autre = $id_a->id_autre;
                $execute = $jugement_autre->save();
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
    
    public function destroy_a($id){
        DB::table('jugements_autres')->where('autres_id_autre', $id)->delete();
        DB::table('autres')->where('id_autre', $id)->delete();
        return back()->with('success','تم الحذف');
    }

   public function edit($id,$d)
    {
        $autre=Autre::where('id_autre',$id)->first();
        return view('admin.edit_autre',compact('autre','d'));
    }


   public function update(Request $request, Autre $autre)
    {
        $this->validate($request,[
            'description_autre'=>'required',
            'present'=>'required',

        ]);
        $autre->description_autre=$request->description_autre;
        $autre->present=$request->present;
        $autre->update();
  
        return redirect()->route('autre.administration',$request->num_dossier)->with('success','تم التحفيض بنجاح.');
 
    }


    public function destroy($id)
    {
        //
    }
}
