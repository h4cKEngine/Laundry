<?php

namespace App\Http\Resources;

use GDebrauwer\Hateoas\Traits\HasLinks;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'orario' => $this->orario,
            'id_user' => $this->id_user,
            'id_washer' => $this->id_washer,
            'id_washing_program' => $this->id_washing_program,
            '_links' => $this->links()
        ];
    }
}
