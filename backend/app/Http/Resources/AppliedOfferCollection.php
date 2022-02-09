<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AppliedOfferCollection extends ResourceCollection
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
    public static $wrap = 'offers';

    public function toArray($request)
    {
        return [
            'offers' => AppliedOfferResource::collection($this->collection),
        ];
    }
}
