<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['paiement_id','id_donateur','date','montant','status'];
    protected $primaryKey= 'paiement_id';
    public $timestamps = false;
    protected $table = 'paiements';
    
    public function getDonator()
    {
        return $this->hasOne('App\Donateur');
    }
}
