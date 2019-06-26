<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderateur extends Model
{
    protected $fillable = ['moderateur_id','nom','prenom','cin','nationalite','ville','adresse','zip','tel','email','photo','type','mdp','active'];
    protected $primaryKey = 'moderateur_id';
    protected $table = 'moderateurs';
    protected $hidden = ['mdp', 'type',];
    public $timestamps = false;
}
