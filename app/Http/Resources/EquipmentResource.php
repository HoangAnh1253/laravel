<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "serial_number" => $this->serial_number,
            "name" => $this->name,
            "desc" => $this->desc,
            "status" => $this->status,
            "category" => $this->category,
            "user" => $this->user
        ];
    }
}