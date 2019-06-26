<?php

namespace App\Http\Controllers;

use App\Paiement as p;
use Illuminate\Http\Request;
use App\Http\Resources\PaiementCollection as pc;
use App\Http\Resources\PaiementResource as pr;
use Validator;

class PaiementController extends Controller
{
    public function index()
    {
        return new pc(p::all());
    }
    
    public function create(Request $r)
    {
        $v= Validator::make($r->all(),[
            'donateur_id'=>'required|numeric',
            'methode'=>'required|string',
            'date'=>'required',
            'montant'=>'required|numeric',
            'status'=>'required|string',
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors()
            ],204);
        }

        $pai=p::create($r->all());
        return response()->json([
            'success'=>true,
            'message'=>'Paiement inserted successfuly',
            'data' => $pai
        ],201);
    }


    public function show($id)
    {
        return pr(p::findOrFail($id));
    }


    public function destroy($id)
    {
        $pai = p::findOrFail($id);
        $pai->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Paiement deleted successfuly',
            'data' => $doc
        ],201);
    }
}
