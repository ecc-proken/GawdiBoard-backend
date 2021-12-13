<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    /**
     * 適用する「データ」ラッパー
     *
     * @var string
     */
    public static $wrap = 'work';

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'note' => $this->note,
            'picture' => $this->picture,
            'link' => $this->link,
            'post_date' => $this->post_date,
            'student_number' => $this->users->student_number,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
