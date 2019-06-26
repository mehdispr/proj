<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['document_id','type','description','photo','id_projet'];
    protected $primaryKey = 'document_id';
    protected $table = 'documents';
    public $timestamps = false;
    
    public function projet()
    {
        return $this->hasOne(Projet::class);
    }
}
