<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = ['projet_id','demandeur_id','moderateur_id','titre','categorie','montant','restant','date_debut','date_fin','description','img','visited'];
    protected $primaryKey = 'projet_id';
    protected $table = 'projets';
    public $timestamps = false;

    public function documents(){
        return $this->hasMany(Document::class);
    }
    

    public function comments(){
        return $this->hasMany(Commentaire::class);
    }

}
