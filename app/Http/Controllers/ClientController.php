<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Client=Client::all();
        $Array_l=[];
        foreach ($Client as $L) {
            $User=User::find($L->id_user);
            array_push($Array_l,array_merge($L->toArray(),$User->toArray()));
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
        $User->user_type='Client';
        $User->save();

        $Client=new Client();
        $Client->id_user=$User->id;
        $Client->save();

        return response()->json(array_merge($User->toArray(),$Client->toArray()),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // $Array_l=[];
        $Client=Client::find($id);
        $User=User::find($Client->id_user);
      //  array_push($Array_l,array_merge($Client->toArray(),$User->toArray()));
        return response()->json(array_merge($Client->toArray(),$User->toArray()),200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Client=Client::find($id);
        $User=User::find($Client->id_user);
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
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Client=Client::find($id);
        $User=User::find($Client->id_user);
        $User->delete();
        $Client->delete();
        return response()->json($User,200);
    }
}
