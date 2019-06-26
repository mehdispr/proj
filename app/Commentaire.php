<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $fillable = ['commentaire_id','id_projet','id_user','date','texte'];
    protected $primaryKey = 'commentaire_id';
    protected $table = 'commentaires';
    public $timestamps = false;

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
