<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentaireResource extends JsonResource
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
            'id_commentaire'=>$this->id_commentaire,
            'id_projet'=>$this->id_projet,
            'id_user'=>$this->id_user,
            'date'=>$this->date,
            'texte'=>$this->texte
        ];
    }
}
