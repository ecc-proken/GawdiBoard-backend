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
            'student_number'    => $this->student_number,
            'user_name'         => $this->user_name,
            'email'             => $this->email,
            'link'              => $this->link,
            'self_introduction' => $this->self_introduction,
            'create_at '        => $this->create_at,
        ];
    }
}
