<?php

namespace App\Http\Controllers;

use App\Livreur;
use App\Pharmacie;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class Livreur_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Livreur=Livreur::all();
        $Array_l=[];
        foreach ($Livreur as $L) {
            $User=User::find($L->id_user);
            $Pharmacie=Pharmacie::find($L->id_pharmacie);
            array_push($Array_l,array_merge($L->toArray(),$Pharmacie->toArray(),$User->toArray()));
        }

        return response()->json($Array_l,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $User=new User();
        $User->nom=$request->input('nom');
        $User->prenom=$request->input('prenom');
        $User->adresse=$request->input('adresse');
        $User->telephone=$request->input('telephone');
        $User->email=$request->input('email');
        $User->password=Hash::make($request->input("password"));
        $User->user_type='Livreur';
        $User->save();

        $Livreur=new Livreur();
        $Livreur->id_user=$User->id;
        $Livreur->id_pharmacie=$request->input('id_pharmacie');
        $Livreur->save();

        return response()->json(array_merge($User->toArray(),$Livreur->toArray()),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Livreur  $livreur
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //    $Array_l=[];
        $Livreur=Livreur::find($id);
        $User=User::find($Livreur->id_user);
        $Pharmacie=Pharmacie::find($Livreur->id_pharmacie);

      //  array_push($Array_l,array_merge($Livreur->toArray(),$User->toArray()));
        return response()->json(array_merge($Livreur->toArray(),$Pharmacie->toArray(),$User->toArray()),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Livreur  $livreur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Livreur=Livreur::find($id);
        $User=User::find($Livreur->id_user);
        $User->nom=$request->input('nom');
        $User->prenom=$request->input('prenom');
        $User->adresse=$request->input('adresse');
        $User->telephone=$request->input('telephone');
        $User->email=$request->input('email');
        $User->save();
        return response()->json($User,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Livreur  $livreur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Livreur=Livreur::find($id);
        $User=User::find($Livreur->id_user);
        $User->delete();
        $Livreur->delete();
        return response()->json($User,200);
    }
}
