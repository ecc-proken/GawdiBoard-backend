<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PromotionCollection extends ResourceCollection
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
    public static $wrap = 'promotions';

    public function toArray($request)
    {
        return [
            'promotions' => PromotionResource::collection($this->collection),
        ];
    }
}
