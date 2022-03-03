<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
    public static $wrap = 'chat';

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'offer_id' => $this->offer_id,
            'chat' => $this->chat,
            'student_number' => $this->student_number,
            'created_at' => $this->created_at,
        ];
    }
}
