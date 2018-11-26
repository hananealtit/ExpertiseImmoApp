<?php

namespace App\Http\Controllers;

use App\Avocat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class AvocatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $avocats=DB::table('avocats')->paginate(6);
        return view('admin.gestion_avocat',compact('avocats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'genre' => 'required',
                'nom_avocat' => 'required',
                'adresse_avocat' => 'required',
                'ville_avocat' => 'required',
            ]);
            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400);
            }
            else{
                $avocat = new Avocat();
                $avocat->nom_avocat = $request->nom_avocat;
                $avocat->adresse_avocat = strip_tags($request->adresse_avocat);
                $avocat->ville = $request->ville_avocat;
                $avocat->genre = ($request->genre === 'true') ? 'F' : 'M';
                $execute = $avocat->save();
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
    public function dataav(){
     $array=[];
     $avocats=Avocat::pluck('nom_avocat','id_avocat');
     foreach ($avocats->all() as $k=>$avocat) {
         $array[$k]=$avocat;
     }
     $a=json_encode($array);
        echo($a);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $avocat=Avocat::where('id_avocat',$id)->first();
        return view('admin.edit_avocat',compact('avocat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, Avocat $avocat)
    {
        $this->validate($request,[
            'nom_avocat'=>'required',
            'adresse_avocat'=>'required',
            'ville'=>'required',
            'genre'=>'required',

        ]);
        $avocat->nom_avocat=$request->nom_avocat;
        $avocat->adresse_avocat=$request->adresse_avocat;
        $avocat->ville=$request->ville;
        $avocat->genre=$request->genre;
        $avocat->update();
        return redirect()->route('avocat.index')->with('success','تم التحفيض بنجاح.');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
