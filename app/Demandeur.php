<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demandeur extends Model
{
    protected $fillable = ['demandeur_id','nom','prenom','cin','nationalite','ville','adresse','zip','tel','email','photo','type','mdp'];
    protected $primaryKey = 'demandeur_id';
    protected $table = 'demandeurs';
    protected $hidden = ['mdp', 'type',];
    public $timestamps = false;

    public function getProjet(){
        return $this->hasMany('App/Projet');
    } 
}
