<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donateur extends Model
{
    protected $fillable = ['donateur_id','nom','prenom','cin','nationalite','ville','adresse','zip','tel','email','photo','type','mdp'];
    protected $primaryKey = 'donateur_id';
    protected $table = 'donateurs';
    protected $hidden = ['mdp', 'type',];
    public $timestamps = false;
}
