<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    function login(Request $req){
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $validator = \Validator::make($req->all(),$rules);
            if($validator->fails()){
                $response['result'] = false;
                $response['message'] = $validator->getMessageBag()->toArray();
                return Response()->json($response, 200);
            }
            $user = User::where('email' , $req->email)->first();

            if(!$user){
                $response['result'] = false;
                $response['message'] = "Email does not match";
                return response()->json($response,200);
            }

            if($user->email == $req->email && Hash::Check($req->password , $user->password)){
                $response['result'] = true;
                $response['token'] = $user->createToken('my-app-token')->plainTextToken;
                $response['user'] = $user;
                $response['message'] = "Login success";
                return response()->json($response,200);
            }else{
                $response['result'] = false;
                // $response['error_keys'] = ['message'];
                $response['message'] = "password not match";
                return response()->json($response,200);
            }
    }

    function logout(){
        if(Auth::user()->tokens()->delete()){
            $response['result'] = true;
            $response['message'] = "Loged Out successfully";
            return response()->json($response,200);
        }
    }

    function test(){
        return "working";
    }
}
