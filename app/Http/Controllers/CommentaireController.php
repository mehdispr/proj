<?php

namespace App\Http\Controllers;

use App\Commentaire as c;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\CommentaireCollection as cc;
use App\Http\Resources\CommentaireResource as cr;

class CommentaireController extends Controller
{
    
    public function index()
    {
        return new cc(c::all());
    }

    public function create(Request $r)
    {
        $v = Validator::make($r->all(),[
            'projet_id'=>'required|numeric',
            'texte'=>'required'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors()
            ],204);
        }

        $com=c::create($r->all());
        return response()->json([
            'success'=>true,
            'message'=>'Comment inserted successfuly',
            'data' => $com
        ],201);
    }


    public function show($id)
    {
        return new cr(c::findOrFail($id));
    }

    public function update(Request $request,$id)
    {
        $com=c::findOrFail($id);
        $v = Validator::make($r->all(),[
            'projet_id'=>'required|numeric',
            'texte'=>'required'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors()
            ],204);
        }

        $com->update($r->all());
        return response()->json([
            'success'=>true,
            'message'=>'Comment updated successfuly',
            'data' => $com
        ],201);
    }

    public function destroy($id)
    {
        $com = c::findOrFail($id);
        $com->delete();
        return response()->json([
            'success'=>false,
            'message'=>'Comment deleted successfuly',
            'data' => $com
        ],201);
    }
}
