<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'id_document'=> $this->id_document,
            'type'=> $this->type,
            'description'=> $this->description,
            'photo'=> $this->photo,
            'id_projet'=> $this->id_projet
        ];

    }
}
