<?php

namespace App\Http\Controllers;

use App\Projet as p;
use App\Commentaire as c;
use App\Moderateur as m;
use App\Paiement as pa;
use App\Don as d;
use Illuminate\Http\Request;
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
            'message' => 'Project deleted successfully',
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
                'projet_id'=>'required|numeric'
            ]);

            // $proj =p::findOrFail($r->projet_id)->comments;
            $proj = c::where('projet_id',$r->projet_id)
                    ->join('donateurs','donateurs.donateur_id','=','commentaires.id_user')
                    ->select('commentaires.texte as texte','donateurs.nom as nom','donateurs.prenom as prenom','commentaires.date')->get();
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
        $proj = p::orderBy('visited','desc')->take(6)->get();
        return response()->json([
            'success'=>true,
            'message'=>'donnation accepted',
            'data'=>$proj
        ],201);
    }
    
    public function newProjects()
    {
        $proj = p::orderBy('date_debut','desc')->take(6)->get();
        return response()->json([
            'success'=>true,
            'message'=>'donnation accepted',
            'data'=>$proj
        ],201);
    }

    public function getprojects(Request $r)
    {
        $v=Validator::make($r->all(),[
            'demandeur_id'=>'required|numeric'
        ]);
        
        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Donantion error',
                'errors' => $v->errors()
            ],204);
        }

        $proj=p::where('demandeur_id',$r->demandeur_id)->get();

        return response()->json([
            'success'=>true,
            'message'=>'donnation accepted',
            'data'=>$proj
        ],201);
    }

    public function getdon(Request $r)
    {
        $v=Validator::make($r->all(),[
            'projet_id'=>'required|numeric'
        ]);
        if($v->fails()){
            return response()->json([
                'success' => false,
                'message' => ' error',
                'errors' => $v->errors()
            ],204);
        }
        $com = d::where('projet_id',$r->projet_id)
                ->join('donateurs','donateurs.donateur_id','=','dons.donateur_id')
                ->join('paiements','paiements.don_id','=','dons.don_id')
                ->select('donateurs.nom as nom','donateurs.prenom as prenom','paiements.date as date','paiements.montant')->orderBy('paiements.date','desc')
                ->limit(3)->get();

        return response()->json([
            'success'=>true,
            'message'=>'Comments',
            'data'=>$com
        ],201);
    }

    public function getdemandeur($projet_id){
        
        $dem = p::where('projet_id',$projet_id)
                ->join('demandeurs','demandeurs.demandeur_id','=','projets.demandeur_id')
                ->select('demandeurs.nom','demandeurs.prenom','demandeurs.ville','demandeurs.tel','demandeurs.email')->first();
        return response()->json($dem,201);
    }

}
