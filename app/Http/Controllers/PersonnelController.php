<?php

namespace App\Http\Controllers;

use App\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnels=Personnel::where('visible',1)->paginate(5);
        return view('admin.gestion_personnel',compact('personnels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_personnel');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'tel_personnel'=>'required',
            'email'=>'required|unique:personnels',
            'adresse'=>'required',
            'fonction'=>'required',
            'genre'=>'required'
        ]);
        $personnel =new Personnel();
        $personnel->genre=$request->genre;
        $personnel->name=$request->name;
        $personnel->tel_personnel=$request->tel_personnel;
        $personnel->email=$request->email;
        $personnel->adresse=$request->adresse;
        $personnel->fonction=$request->fonction;
        $personnel->visible=1;
        $personnel->save();
        return redirect()->route('personnel.index')->with('success','تم التحفيض بنجاح.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $personnel=Personnel::where('id_personnel',$id)->first();
       return view('admin.edit_personnel',compact('personnel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personnel $personnel)
    {

        $this->validate($request,[
            'name'=>'required',
            'tel_personnel'=>'required',
            'email'=>'required',
            'adresse'=>'required',
            'fonction'=>'required',
            'genre'=>'required'
        ]);
        $personnel->genre=$request->genre;
        $personnel->name=$request->name;
        $personnel->tel_personnel=$request->tel_personnel;
        $personnel->email=$request->email;
        $personnel->adresse=$request->adresse;
        $personnel->fonction=$request->fonction;
        $personnel->visible=1;
        $personnel->update();
        return redirect()->route('personnel.index')->with('success','تم التحفيض بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('personnels')->where('id_personnel',$id)->update(['visible'=>0]);

        return redirect()->route('personnel.index')->with('success','تم الحذف بنجاح');
    }

}
