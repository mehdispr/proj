<?php

namespace App\Http\Controllers;

use App\Moderateur as m;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\ModerateurCollection as mc;
use App\Http\Resources\ModerateurResource as mr;

class ModerateurController extends Controller
{
    public function index()
    {
        return new mc(m::all());
    }
    
    public function show($id_moderateur)
    {
        return new mr(m::findOrFail($id_moderateur));
    }
    
    public function store(Request $r)
    {
        $mod =  m::where('cin',$r->cin)->get()->first();
        if(isset($mod)){
            $response = [
                'success' => false,
                'message' => 'Creation error',
                'errors' => 'This moderateur exists already',
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
            $r->photo->move( public_path('images/moderateurs'), $filename);

            $input['photo'] = $filename;
        }

        $moderateur = m::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Moderateur created successfully',
            'data' => $moderateur
        ],201);

    }

    
    public function update(Request $r,$id_mod)
    {
        $mod = m::find($id_mod);
        if(is_null($mod)){
            return response()->json([
                'success'=>false,
                'message'=>'Moderateur not found'
            ],404);

        }
        $v = Validator::make($r->all(),[
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'cin' => 'required|string',
            'email' => 'required|email',
            'ville' => 'required',
            'adresse' => 'required|string',
            'mdp' => 'required|min:8',
            'tel' => 'required',
            'active'=>'required'
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
            $r->photo->move( public_path('images/moderateurs'), $filename);

            $input['photo'] = $filename;
        }

        $mod->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Moderateur updated successfully',
            'data' => $mod
        ],201);
    }
    

    public function destroy($id)
    {
        $mod=m::findOrFail($id);
        $mod->delete();
        return response()->json([
            'success' => true,
            'message' => 'Moderateur deleted successfully',
            'data' => $mod
        ],201);
    }
}
