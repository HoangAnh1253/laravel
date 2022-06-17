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
            "email" => $this->email,
            "password" => $this->when($this->is_admin, $this->password),
            "name" => $this->name,
            "gender" => $this->gender,
            "birthdate" => $this->phone_number,
            "is_admin" => $this->is_admin
        ];
    }
}