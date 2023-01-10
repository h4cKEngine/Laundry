<?php

namespace App\Http\Resources;

use GDebrauwer\Hateoas\Traits\HasLinks;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'email' => $this->email,
            'nome' => ucfirst($this->nome),
            'cognome' => ucfirst($this->cognome),
            'matricola' => $this->matricola,
            'nazionalita' => $this->nationalita,
            'ruolo' => $this->ruolo,
            'stato' => $this->deleted_at,
            '_links' => $this->links()
        ];
    }
}
