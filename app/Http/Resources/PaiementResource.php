<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaiementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
            ['id_paiement'=>$this->id_paiement,'id_donateur'=>$this->id_donateur,'methode'=>$this->methode,'date'=>$this->date,'montant'=>$this->montant,'status'=>$this->status];
        
    }
}
