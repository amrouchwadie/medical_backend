<?php

namespace App\Http\Controllers;

use App\admin_pharmacie;
use App\User;
use App\Pharmacie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class Admin_pharmacie_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_pharmacie=admin_pharmacie::all();
        $Array_l=[];
        foreach ($admin_pharmacie as $a) {
            $User=User::find($a->id_user);
            $Pharmacie=Pharmacie::find($a->id_pharmacie);
            array_push($Array_l,array_merge($a->toArray(),$User->toArray(),$Pharmacie->toArray()));
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
        $User->user_type='Admin_pharmacie';
        $User->save();

        $admin_pharmacie=new admin_pharmacie();
        $admin_pharmacie->id_user=$User->id;
        $admin_pharmacie->id_pharmacie=$request->input('id_pharmacie');
        $admin_pharmacie->save();

        return response()->json(array_merge($User->toArray(),$admin_pharmacie->toArray()),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\admin_pharmacie  $admin_pharmacie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin_pharmacie=admin_pharmacie::find($id);
        $User=User::find($admin_pharmacie->id_user);
        return response()->json(array_merge($admin_pharmacie->toArray(),$User->toArray()),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\admin_pharmacie  $admin_pharmacie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $admin_pharmacie=admin_pharmacie::find($id);
        $admin_pharmacie->id_pharmacie=$request->input('id_pharmacie');
        $admin_pharmacie->save();

        $User=User::find($admin_pharmacie->id_user);
        $User->nom=$request->input('nom');
        $User->prenom=$request->input('prenom');
        $User->adresse=$request->input('adresse');
        $User->telephone=$request->input('telephone');
        $User->email=$request->input('email');
        $User->save();

        return response()->json(array_merge($User->toArray(),$admin_pharmacie->toArray()),200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\admin_pharmacie  $admin_pharmacie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin_pharmacie=admin_pharmacie::find($id);
        $User=User::find($admin_pharmacie->id_user);
        $admin_pharmacie->delete();
        $User->delete();
        return response()->json(array_merge($User->toArray(),$admin_pharmacie->toArray()),200);

    }
}
