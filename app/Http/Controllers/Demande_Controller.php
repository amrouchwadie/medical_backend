<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Client;
use App\User;
use App\Livreur;
use App\Pharmacie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Demande_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Array=[];
        $Livreurs=[];
        $Clients=[];
        $Demande=Demande::all();
        foreach ($Demande as $d) {
            // GET INFO OF LIVREUR
            $Livreur=Livreur::find($d->id_livreur);
            if(!empty($Livreur)){
                $UserL=User::find($Livreur->id_user);
                $Livreurs=['Livreur_nom'=>$UserL->nom,'Livreur_prenom'=>$UserL->prenom,'Livreur_adresse'=>$UserL->adresse,'Livreur_telephone'=>$UserL->telephone,'Livreur_email'=>$UserL->email];
            }
            // GET INFO OF CLIENT
            $Client=Client::find($d->id_client);
            if(!empty($Client)){
                $UserC=User::find($Client->id_user);
                $Clients=['Client_nom'=>$UserC->nom,'Client_prenom'=>$UserC->prenom,'Client_adresse'=>$UserC->adresse,'Client_telephone'=>$UserC->telephone,'Client_email'=>$UserC->email];
            }
            // GET INFO OF PHARMACIE
            $Pharmacie=Pharmacie::find($d->id_pharmacie);
            array_push($Array,array_merge($d->toArray(),$Livreurs,$Clients,$Pharmacie->toArray()));
        }
        return response()->json($Array,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Demande=new Demande();
        $Demande->description=$request->input('description');
        if($request->file('demande_image')!=null){
            $Demande->demande_image=$request->file('demande_image')->getClientOriginalName();
            $request->file('demande_image')->storeas('public',$request->file('demande_image')->getClientOriginalName());
        }
        $Demande->status=$request->input('status');
        $Demande->message_refuse=$request->input('message_refuse');
        $Demande->id_client=$request->input('id_client');
        $Demande->id_livreur=$request->input('id_livreur');
        $Demande->id_pharmacie=$request->input('id_pharmacie');
        $Demande->save();
        return response()->json($Demande,200);
    }

    
    public function show($id)
    {
        $oneLivreur=[];
        $oneClient=[];
        $Demande=Demande::find($id);
        //LV
        $Livreur=Livreur::find($Demande->id_livreur);
        if(!empty($Livreur)){
            $UserL=User::find($Livreur->id_user);
            $oneLivreur=['Livreur_nom'=>$UserL->nom,'Livreur_prenom'=>$UserL->prenom,'Livreur_adresse'=>$UserL->adresse,'Livreur_telephone'=>$UserL->telephone,'Livreur_email'=>$UserL->email];
        }
        //CL
        $Client=Client::find($Demande->id_client);
        if(!empty($Client)){
            $UserC=User::find($Client->id_user);
            $oneClient=['Client_nom'=>$UserC->nom,'Client_prenom'=>$UserC->prenom,'Client_adresse'=>$UserC->adresse,'Client_telephone'=>$UserC->telephone,'Client_email'=>$UserC->email];
        }
        //PH
        $Pharmacie=Pharmacie::find($Demande->id_pharmacie);
        return response()->json(array_merge($Demande->toArray(),$oneLivreur,$oneClient,$Pharmacie->toArray()),200);
    }

    public function get_demande_by_client($id)
    {
        $Array=[];
        $oneLivreur=[];
        $Demande=Demande::where('id_client',$id)->get();
        foreach ($Demande as $d) {
            //LV
            $Livreur=Livreur::find($d->id_livreur);
            if(!empty($Livreur)){
                $UserL=User::find($Livreur->id_user);
                $oneLivreur=['Livreur_nom'=>$UserL->nom,'Livreur_prenom'=>$UserL->prenom,'Livreur_adresse'=>$UserL->adresse,'Livreur_telephone'=>$UserL->telephone,'Livreur_email'=>$UserL->email];
            }
            //PH
            $Pharmacie=Pharmacie::find($d->id_pharmacie);
            array_push($Array,array_merge($d->toArray(),$oneLivreur,$Pharmacie->toArray()));
        }
        return response()->json($Array,200);
    }

    public function get_demande_by_livreur($id)
    {
        $Array=[];
        $oneClient=[];
        $Demande=Demande::where('id_livreur',$id)->get();
        foreach ($Demande as $d) {
            // CL
            $Client=Client::find($d->id_client);
            if(!empty($Client)){
                $UserC=User::find($Client->id_user);
                $oneClient=['Client_nom'=>$UserC->nom,'Client_prenom'=>$UserC->prenom,'Client_adresse'=>$UserC->adresse,'Client_telephone'=>$UserC->telephone,'Client_email'=>$UserC->email];
            }
            //PH
            $Pharmacie=Pharmacie::find($d->id_pharmacie);
            array_push($Array,array_merge($d->toArray(),$oneClient,$Pharmacie->toArray()));
        }
        return response()->json($Array,200);
    }

    public function get_demande_by_pharmacie($id)
    {
        $Array=[];
        $oneLivreur=[];
        $oneClient=[];
        $Demande=Demande::where('id_pharmacie',$id)->get();
        foreach ($Demande as $d) {
            //CL
            $Client=Client::find($d->id_client);
            if(!empty($Client)){
                $UserC=User::find($Client->id_user);
                $oneClient=['Client_nom'=>$UserC->nom,'Client_prenom'=>$UserC->prenom,'Client_adresse'=>$UserC->adresse,'Client_telephone'=>$UserC->telephone,'Client_email'=>$UserC->email];
            }
            //LV
            $Livreur=Livreur::find($d->id_livreur);
            if(!empty($Livreur)){
                $UserL=User::find($Livreur->id_user);
                $oneLivreur=['Livreur_nom'=>$UserL->nom,'Livreur_prenom'=>$UserL->prenom,'Livreur_adresse'=>$UserL->adresse,'Livreur_telephone'=>$UserL->telephone,'Livreur_email'=>$UserL->email];
            }
            array_push($Array,array_merge($d->toArray(),$oneLivreur,$oneClient));
        }
        return response()->json($Array,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $Demande=Demande::find($id);
        if($request->input('description')!==null){
            $Demande->description=$request->input('description');
        }
        if($request->input('status')!==null){
            $Demande->status=$request->input('status');
        }
        if($request->input('message_refuse')!==null){
            $Demande->message_refuse=$request->input('message_refuse');
        }
        if($request->input('id_livreur')!==null){
            $Demande->id_livreur=$request->input('id_livreur');
        }
        $Demande->save();
        return response()->json($Demande,200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Demande=Demande::find($id);
        $Demande->delete();
        return response()->json($Demande,200);
    }
}
