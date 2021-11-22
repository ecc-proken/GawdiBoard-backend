<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TagResource;

class OfferResource extends JsonResource
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
            "offer" => [
                "id"             => $this->id,
                "title"          => $this->title,
                "target"         => $this->target,
                "job"            => $this->job,
                "note"           => $this->note,
                "picture"        => $this->picture,
                "link"           => $this->link,
                "post_date"      => $this->post_date,
                "end_date"       => $this->end_date,
                "student_number" => $this->student_number,
                "user_name"      => $this->user_name,
                "user_class"     => $this->user_class,
                'tags'           => TagResource::collection($this->whenLoaded("tags")),
            ],

        ];
    }
}
