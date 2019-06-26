<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = ['projet_id','id_demandeur','id_moderateur','titre','categorie','montant','restant','date_debut','description','img','visited'];
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
