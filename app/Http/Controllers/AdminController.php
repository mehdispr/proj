<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Moderateur;
use Validator;
use App\Http\Resources\AdminResource as ar;
use App\Http\Resources\AdminCollection as ac;

class AdminController extends Controller
{
    public function index(){
        return new ac(Admin::all());
    }
    public function show($id_admin){
        return new ar(Admin::findOrFail($id_admin));
    }


    public function store(Request $r){

        $admin =  Admin::where('cin',$r->cin)->get()->first();
        if(isset($admin)){
            $response = [
                'success' => false,
                'message' => 'Creation error',
                'errors' => 'This admin exists already',
            ];
            return response()->json($response);
        }
        $v = Validator::make($r->all(),[
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'cin' => 'required|string',
            'email' => 'required|email',
            'ville' => 'required',
            'adresse' => 'required|string',
            'mdp' => 'required|min:8',
            'tel' => 'required'
        ]);

        if($v->fails()){
            $response = [
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors(),
            ];
            return response()->json($response);
        }
        $input = $r->all();

        if($r->hasFile('photo')){
            $filename = time().'.'.$r->photo->getClientOriginalExtension();
            $r->photo->move( public_path('images/admins'), $filename);

            $input['photo'] = $filename;
        }

        $admin = Admin::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Admin created successfully',
            'data' => $admin
        ],201);

    }

    public function update(Request $r){
        $admin = Admin::find($r->id_admin);
        if(is_null($admin)){
            return response()->json([
                'success'=>false,
                'message'=>'Admin not found'
            ],404);

        }
        $v = Validator::make($r->all(),[
            'admin_id'=>'required',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'cin' => 'required|string',
            'email' => 'required|email',
            'ville' => 'required',
            'adresse' => 'required|string',
            'mdp' => 'required|min:8',
            'tel' => 'required'
        ]);

        if($v->fails()){
            $response = [
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors(),
            ];
            return response()->json($response);
        }
        $input = $r->all();

        if($r->hasFile('photo')){
            $filename = time().'.'.$r->photo->getClientOriginalExtension();
            $r->photo->move( public_path('images/admins'), $filename);

            $input['photo'] = $filename;
        }

        $admin->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Admin updated successfully',
            'data' => $admin
        ],201);

    }

    public function destroy($id_admin){
        $admin=Admin::findOrFail($id_admin);
        $admin->delete();
        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully',
            'data' => $admin
        ],201);

    }

    public function enableMod(Request $r)
    {
        $v=Validator::make($r->all(),['moderateur_id'=>'required|numeric']);
        if($v->fails()){
            return response()->json([
                'success' =>false,
                'message' => 'Activation error',
                'errors' =>$v->errors()
            ],204);
        }

        $mod=Moderateur::find($r['moderateur_id']);
        if(is_null($mod)){
            return response()->json([
                'success' =>false,
                'message' => 'Activation error',
                'errors' =>'Moderator not found error'
            ],204);
        }

        $mod->update([
            'active'=>1
        ]);

         return response()->json([
                'success' => true,
                'message' => 'Moderator activated successfully',
                'data' => $mod
         ],201);
    }

    public function disableMod(Request $r)
    {
        $v=Validator::make($r->all(),['moderateur_id'=>'required|numeric']);
        if($v->fails()){
            return response()->json([
                'success' =>false,
                'message' => 'Desactivation error',
                'errors' =>$v->errors()
            ],204);
        }

        $mod=Moderateur::find($r['moderateur_id']);
        if(is_null($mod)){
            return response()->json([
                'success' =>false,
                'message' => 'Desactivation error',
                'errors' =>'Moderator not found error'
            ],204);
        }

        $mod->update([
            'active'=>0
        ]);

         return response()->json([
                'success' => true,
                'message' => 'Moderator desactivated successfully',
                'data' => $mod
         ],201);
    }
}

