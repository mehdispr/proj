<?php

namespace App\Http\Controllers;

use App\Document as d;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\DocumentCollection as dc;
use App\Http\Resources\DocumentResource as dr;

class DocumentController extends Controller
{
    public function index()
    {
        return new dc(d::all());
    }
    public function show($id)
    {
        return new dr(d::findOrFail($id));
    }

    public function create(Request $r)
    {
        $v= Validator::make($r->all(),[
            'type' => 'required|string',
            'description' => 'required',
            'photo' => 'required',
            'projet_id' => 'required'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors()
            ],204);
        }

        $doc=d::create($r->all());
        return response()->json([
            'success'=>false,
            'message'=>'Doc inserted successfuly',
            'data' => $doc
        ],201);
    }
    public function update(Request $r,$id)
    {
        $doc = d::findOrFail($id);

        $v= Validator::make($r->all(),[
            'projet_id' => 'required'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors()
            ],204);
        }

        $doc->update();
        return response()->json([
            'success'=>false,
            'message'=>'Doc updated successfuly',
            'data' => $doc
        ],201);
    }

    public function destroy($id)
    {
        $doc = d::findOrFail($id);
        $doc->delete();
        return response()->json([
            'success'=>false,
            'message'=>'Doc deleted successfuly',
            'data' => $doc
        ],201);
    }
}
