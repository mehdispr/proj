<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin as a;
use App\Donateur as d;
use App\Moderateur as m;
use App\Demandeur as dm;
use Validator;

class UserController extends Controller
{
    public function login(Request $r)
    {
        $v=Validator::make($r->all(),[
            'email'=>'required|email',
            'password'=>'required|string',
            'type'=>'required|string'
        ]);

        if($v->fails()){
            $response = [
                'success' => false,
                'message' => 'Login error',
                'errors' => $v->errors(),
            ];
            return response()->json($response);
        }
        switch ($r->type) {
            case 'Donateur':
                $user = d::where([['email',$r->email],['mdp',$r->password]])->first();
                break;
            case 'Demandeur':
                $user = dm::where([['email',$r->email],['mdp',$r->password]])->first();
                break;
            default:
                $user = null;
                break;
        }
        
        

       if(!empty($user)){
           $response=[
               'success'=>true,
               'data'=>$user
           ];
           return response()->json($response);
       };
        $response=[
            'success'=>false,
            'data'=>"Email ou Mot de passe incorrecte."
        ];
        return response()->json($response);
       

    } 
}
