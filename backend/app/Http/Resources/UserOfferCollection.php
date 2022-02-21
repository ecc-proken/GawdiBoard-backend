<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserOfferCollection extends ResourceCollection
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
    public static $wrap = 'userOffer';

    public function toArray($request)
    {
        return [
            'userOffer' => UserOfferResource::collection($this->collection),
        ];
    }
}
