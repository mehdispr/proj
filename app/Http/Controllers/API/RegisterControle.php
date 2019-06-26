<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;

class RegisterControle extends Controller
{
    public function register(Request $r){

        $validator= Validator::make($r->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error.',
                'errors' => $validator->errors()
            ];
    
            return response()->json($response);
        }

        $input= $r->all();
        $input['password']= bcrypt($input['password']);
        $user= User::create($input);
        $success['messager'] = 'User register successfully.';
        $success['name'] = $user->name;
        $success['token']= $user->createToken('MyApp')->accessToken;
        return response()->json($success);
    }
}
