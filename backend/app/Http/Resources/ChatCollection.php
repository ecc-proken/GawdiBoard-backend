<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    /**
     * 適用する「データ」ラッパー
     *
     * @var string
     */
    public static $wrap = 'chats';

    public function toArray($request)
    {
        return [
            'chats' => ChatResource::collection($this->collection),
        ];
    }
}
