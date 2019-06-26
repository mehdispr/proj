<?php

namespace App\Http\Controllers;

use App\Don as d;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\DonConnection as dc;
use App\Http\Resources\DonResource as dr;

class DonController extends Controller
{
    
    public function index()
    {
        return dc(d::all());
    }

    public function create(Request $r)
    {
        $v=Validator::make($r->all(),[
            'paiement_id'=>'required',
            'projet_id'=>'required',
            'montant'=>'required',
            'date'=>'required',
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors()
            ],204);
        }

        $don=d::create($r->all());
        return $r->all();
        return response()->json([
            'success'=>false,
            'message'=>'Donation made successfuly',
            'data' => $don
        ],201);
    }

    public function show($don)
    {
        return new dr(d::findOrFail($don));
    }
    
    
    public function destroy($don)
    {
        $don = d::findOrFail($don);
        $don->delete();
        return response()->json([
            'success'=>false,
            'message'=>'Donation deleted successfuly',
            'data' => $don
        ],201);
    }
}
