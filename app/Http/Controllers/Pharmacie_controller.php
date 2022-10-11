<?php

namespace App\Http\Controllers;

use App\Pharmacie;
use Illuminate\Http\Request;

class Pharmacie_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Pharmacie = Pharmacie::all();
        return response()->json($Pharmacie,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Pharmacie=new Pharmacie();
        $Pharmacie->nom_pharmacie=$request->input('nom_pharmacie');
        $Pharmacie->adresse_pharmacie=$request->input('adresse_pharmacie');
        $Pharmacie->telephone=$request->input('telephone');
        $Pharmacie->email=$request->input('email');
        $Pharmacie->compte_banc=$request->input('compte_banc');
        $Pharmacie->save();
        return response()->json($Pharmacie,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacie  $pharmacie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Pharmacie=Pharmacie::find($id);
        return response()->json($Pharmacie,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacie  $pharmacie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $Pharmacie=Pharmacie::find($id);
        $Pharmacie->nom_pharmacie=$request->input('nom_pharmacie');
        $Pharmacie->adresse_pharmacie=$request->input('adresse_pharmacie');
        $Pharmacie->telephone=$request->input('telephone');
        $Pharmacie->email=$request->input('email');
        $Pharmacie->compte_banc=$request->input('compte_banc');
        $Pharmacie->save();
        return response()->json($Pharmacie,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacie  $pharmacie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Pharmacie=Pharmacie::find($id);
        $Pharmacie->delete();
        return response()->json($Pharmacie,200);
    }
}
