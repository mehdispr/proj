<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    protected $fillable = ['don_id','id_paiement','id_projet','hide'];
    protected $primaryKey = 'don_id';
    protected $table = 'dons';
    
    function getProj()
    {
        return $this->hasOne('App\Projet');
    }
}
