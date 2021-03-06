<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
    public static $wrap = 'promotion';

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'note' => $this->note,
            'picture' => $this->picture,
            'link' => $this->link,
            'post_date' => $this->post_date,
            'end_date' => $this->end_date,
            'student_number' => $this->student_number,
            'user_name' => $this->users->user_name,
            'user_class' => $this->user_class,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
