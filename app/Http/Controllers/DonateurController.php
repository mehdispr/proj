<?php

namespace App\Http\Controllers;

use App\Donateur as d;
use App\Don;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\DonateurRessource as dr;
use App\Http\Resources\DonateurCollection as dc;

class DonateurController extends Controller
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
        $donateur =  d::where('cin',$r->cin)->get()->first();
        if(isset($donateur)){
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

        $donateur = d::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Donator created successfully',
            'data' => $donateur
        ],201);

    }

    
    public function update(Request $r,$id)
    {
        $donateur = d::find($id);
        if(is_null($donateur)){
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

        $donateur->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Donator updated successfully',
            'data' => $donateur
        ],201);
    }
    

    public function destroy($id)
    {
        $donateur=d::findOrFail($id);
        $donateur->delete();
        return response()->json([
            'success' => true,
            'message' => 'Donator deleted successfully',
            'data' => $donateur
        ],201);
    }

    public function donnation(Request $r)
    {
        $v=Validator::make($r->all(),[
            'donateur_id'=>'required'
        ]);

        if($v->fails()){
            $response = [
                'success' => false,
                'message' => 'Error',
                'errors' => $v->errors(),
            ];
            return response()->json($response);
        }

        $don =Don::where('donateur_id',$r->donateur_id)
                ->join('projets','projets.projet_id','=','dons.projet_id')
                ->join('paiements','paiements.don_id','=','dons.don_id')
                ->select('dons.don_id','projets.titre','projets.montant as montant_projet','paiements.montant as donnation')->get();

        return response()->json([
            'success' => true,
            'message' => 'Donnation retrieved',
            'data' => $don
        ],201);
    }
    
}
