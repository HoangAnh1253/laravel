<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id" => $this->id,
            "email" => $this->email,
            "password" => $this->when($this->is_admin, $this->password),
            "name" => $this->name,
            "gender" => $this->gender,
            "phone_number" => $this->phone_number,
            "birthdate" => $this->birthdate,
            "is_admin" => $this->is_admin
        ];
    }
}