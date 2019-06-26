<?php

namespace App\Http\Controllers;

use App\Demandeur as d;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\DemandeurResource as dr;
use App\Http\Resources\DemandeurCollection as dc;

class DemandeurController extends Controller
{
    public function index()
    {
        return new dc(d::all());
    }
    
    public function show($id)
    {
        return new dr(d::findOrFail($id));
    }
    
    public function store(Request $r)
    {
        $dom =  d::where('cin',$r->cin)->get()->first();
        if(isset($dom)){
            $response = [
                'success' => false,
                'message' => 'Creation error',
                'errors' => 'This donator exists already',
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
            $r->photo->move( public_path('images/donateurs'), $filename);

            $input['photo'] = $filename;
        }

        $dom = d::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Donator created successfully',
            'data' => $dom
        ],201);

    }

    
    public function update(Request $r,$id)
    {
        $dom = d::find($id);
        if(is_null($dom)){
            return response()->json([
                'success'=>false,
                'message'=>'Donator not found'
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
            $r->photo->move( public_path('images/donateurs'), $filename);

            $input['photo'] = $filename;
        }

        $dom->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Donator updated successfully',
            'data' => $dom
        ],201);
    }
    

    public function destroy($id)
    {
        $dom=d::findOrFail($id);
        $dom->delete();
        return response()->json([
            'success' => true,
            'message' => 'Donator deleted successfully',
            'data' => $dom
        ],201);
    }
    
}
