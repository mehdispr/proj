<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id_projet'=>$this->id_projet,
            'id_demandeur'=>$this->id_demandeur,
            'id_moderateur'=>$this->id_moderateur,
            'titre'=>$this->titre,
            'categorie'=>$this->categorie,
            'montant'=>$this->montant,
            'restant'=>$this->restant,
            'date_debut'=>$this->date_debut,
            'description'=>$this->description,
            'visited'=>$this->visited
        ];
    }
}
