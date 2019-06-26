<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'id_admin' => $this->id_admin ,
            'nom' => $this->nom ,
            'prenom' => $this->prenom ,
            'cin' => $this->cin ,
            'nationalite' => $this->nationalite ,
            'ville' => $this->ville ,
            'adresse' => $this->adresse ,
            'zip' => $this->zip ,
            'tel' => $this->tel ,
            'email' => $this->email ,
            'photo' => $this->photo ,
            'type' => $this->type ,
            'mdp' => $this->mdp
        ];
    }
}
