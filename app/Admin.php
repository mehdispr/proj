<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['admin_id','nom','prenom','cin','nationalite','ville','adresse','zip','tel','email','photo','type','mdp'];
    protected $primaryKey = 'admin_id';
    protected $table = 'admins';
    protected $hidden = ['mdp', 'type',];
    public $timestamps = false;
}
