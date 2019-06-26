<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonResource extends JsonResource
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
            'id_don'=>$this->id_don,
            'id_paiement'=>$this->id_paiement,
            'id_projet'=>$this->id_projet,
            'montant'=>$this->montant,
            'date'=>$this->date,
        ];
    }
}
