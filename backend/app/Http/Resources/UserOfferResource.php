<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserOfferResource extends JsonResource
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
    public static $wrap = 'userOffer';

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_number' => $this->student_number,
            'offer_id' => $this->offer_id,
            'offers' => $this->offers,
        ];
    }
}
