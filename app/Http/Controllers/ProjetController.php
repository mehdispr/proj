<?php

namespace App\Http\Controllers;

use App\Projet as p;
use Illuminate\Http\Request;
use App\Moderateur as m;
use App\Commentaire as c;
use Validator;
use App\Http\Resources\ProjetCollection as pc;
use App\Http\Resources\ProjetResource as pr;
use Carbon\Carbon;
use DB;

class ProjetController extends Controller
{
    
    public function index()
    {
        return new pc(p::all());
    }

    public function show($id)
    {
        $proj = p::findOrFail($id);
        $visited = $proj->visited+1;
        $proj->update([
            'visited'=>$visited
        ]);
        return response()->json([
            'success' => true,
            'data' => $proj
        ],201);
    }

    public function store(Request $r)
    {
        $v= Validator::make($r->all(),[
            'demandeur_id'=>'required|integer',
            'moderateur_id'=>'required|integer',
            'titre'=>'required|string',
            'categorie'=>'required|string',
            'montant'=>'required|numeric',
            'date_debut'=>'required|date',
            'description'=>'required',
        ]);

        if($v->fails()){
            $response=[
                'success'=>false,
                'message'=>'Creation error',
                'errors'=>$v->errors(),
            ];
            return response()->json($response);
        }


        $input=$r->all();
        $date_debut = $r['date_debut'];
        $date_fin = Carbon::createFromFormat('Y-m-d',$date_debut);
        $date_fin->addMonth();
        $date_fin = $date_fin->toDateTimeString();
        $input['date_fin'] = $date_fin;
        $input['restant']= $input['montant'];

        if($r->hasFile('img')){
            $fileName = time().'.'.$r->img->getClientOriginalExtension();
            $r->img->move(public_path('images/projets'), $fileName);
            $input['img']= $fileName;
        }
        
        $proj = p::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
            'data' => $proj
        ],201);

    }

    public function edit(Request $r)
    {
        
        $v= Validator::make($r->all(),[
            'projet_id'=>'required|numeric',
            'demandeur_id'=>'required|integer',
            'moderateur_id'=>'required|integer',
            'titre'=>'required|string',
            'categorie'=>'required|string',
            'montant'=>'required|numeric',
            'description'=>'required',
            ]);
            
        $proj = p::findOrFail($r['id_projet']);

        if($v->fails()){
            $response = [
                'success' => false,
                'message' => 'Creation error',
                'errors' => $v->errors(),
            ];
            return response()->json($response);
        }
        $input=$r->all();
        
        if($r->hasFile('img')){
            $fileName = time().'.'.$r->img->getClientOriginalExtension();
            $r->img->move(public_path('images/projets'), $fileName);
            $input['img']= $fileName;
        }
        
        $proj->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => $proj
        ],201);
    }

    public function destroy($id)
    {
        $proj=p::findOrFail($id);
        $proj->delete();
        return response()->json([
            'success' => true,
            'message' => 'Moderateur deleted successfully',
            'data' => $proj
        ],201);
    }


    public function rechercheNom(Request $r){
        $v = Validator::make($r->all(),[
            'titre'=>'required|string'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Search error',
                'errors' => $v->errors()
            ],204);
        }
        $proj = p::where('titre',$r->titre)->get();
        return response()->json([
            'success' => true,
            'data' => $proj
        ],201);
    }

    public function limiteMontant(Request $r)
    {
        $v = Validator::make($r->all(),[
            'montant'=>'required|string'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Search error',
                'errors' => $v->errors()
            ],204);
        }

        $proj = p::where('montant','<=',$r->montant)->get();
        return response()->json([
            'success' => true,
            'data' => $proj
        ],201);
    }

    public function orderByMontant(Request $r)
    {
        $v = Validator::make($r->all(),[
            'par'=>'required|string|in:asc,desc'
        ]);
        $proj = p::orderBy('montant',$r->par)->get();
        return response()->json([
            'success' => true,
            'data' => $proj
        ],201);
    }
    public function filtreCat(Request $r)
    {
        $v = Validator::make($r->all(),[
            'cat'=>'required|string'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Search error',
                'errors' => $v->errors()
            ],204);
        }

        $proj = p::where('categorie',$r->cat)->get();

        return response()->json([
            'success' => true,
            'data' => $proj
        ],201);
    }

    public function getComments(Request $r)
    {
            $v = Validator::make($r->all(),[
                'id_projet'=>'required|numeric'
            ]);

            $proj =p::findOrFail($r->id_projet)->comments;
            
            return response()->json([
                'success' => true,
                'data' => $proj
            ],201);
    }

    public function faireDon(Request $r)
    {
        $v= Validator::make($r->all(),[
            'id_projet'=>'required|numeric',
            'id_don'=>'required|numeric',
            'montant'=>'required|numeric',
            'date'=>'required|date'
        ]);

        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Donantion error',
                'errors' => $v->errors()
            ],204);
        }

        $proj=p::findOrFail($r->id_projet);
        $rest = $proj->restant - $r->montant;
        if($rest<0){
            $proj->montant = $proj->montant - $rest;
        }
        $proj->update([
            'restant'=>$rest
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'donnation accepted',
            'data'=>$proj
        ],201);
    }
    public function topvisited()
    {
        $proj = p::orderBy('visited','desc')->get();
        return response()->json([
            'success'=>true,
            'message'=>'donnation accepted',
            'data'=>$proj
        ],201);
    }

}
