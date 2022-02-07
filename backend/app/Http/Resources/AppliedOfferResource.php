<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppliedOfferResource extends JsonResource
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
    public static $wrap = 'offer';

    public function toArray($request)
    {
        return [
            'id' => $this->offers->id,
            'title' => $this->offers->title,
            'target' => $this->offers->target,
            'job' => $this->offers->job,
            'note' => $this->offers->note,
            'picture' => $this->offers->picture,
            'link' => $this->offers->link,
            'post_date' => $this->offers->post_date,
            'end_date' => $this->offers->end_date,
            'student_number' => $this->offers->student_number,
            'user_name' => $this->offers->users->user_name,
            'user_class' => $this->offers->user_class,
            'tags' => TagResource::collection($this->offers->tags),
        ];
    }
}
