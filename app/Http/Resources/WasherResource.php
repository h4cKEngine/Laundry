<?php

namespace App\Http\Resources;

use GDebrauwer\Hateoas\Traits\HasLinks;
use Illuminate\Http\Resources\Json\JsonResource;

class WasherResource extends JsonResource
{   
    use HasLinks;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        return [
            //'squadra casa' => ucwords($this->hostT->club->nome, " "),
            //'squadra ospite' => ucwords($this->guestT->club->nome, " "),
            //'risultato' => $this->risCasa . " - " . $this->risOspite,
            //'data' => date('d-m-Y', strtotime($this->data)),
            //'ora inizio' => substr($this->oraInizio, 0, 5),
            '_links' => $this->links()
        ];
    }
}
