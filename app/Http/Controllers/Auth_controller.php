<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class Auth_controller extends Controller
{

    public function register(Request $request)
    {
        $User=new User();
        $User->nom=$request->input('nom');
        $User->prenom=$request->input('prenom');
        $User->adresse=$request->input('adresse');
        $User->email=$request->input('email');
        $User->telephone=$request->input('telephone');
        $User->password=Hash::make($request->input('password'));
        $User->save();
        return response()->json($User,200);
        
    }
 
 
    public function login(Request $request)
    {
         $loginData = $request->validate([
             'email' => 'required',
             'password' => 'required'
         ]);
        
         if(!auth()->attempt($loginData)) {
             return response(['message'=>'Invalid credentials']);
         }
 
         $accessToken = auth()->user()->createToken('authToken')->accessToken;
 
         return response(['user' => auth()->user(), 'access_token' => $accessToken]);
 
    }
}
