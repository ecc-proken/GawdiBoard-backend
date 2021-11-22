<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
    public static $wrap = 'tags';

    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->tag_name,
            'genre_id'    => $this->tag_genre_id,
            'genre_name'  => $this->genres->genre_name,
            'target_id'   => $this->tag_target_id,
            'target_name' => $this->targets->target_name,
        ];
    }
}
