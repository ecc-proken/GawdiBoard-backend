<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetOffersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        # TODO: ユーザー認証が出来次第ロジックを記入
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'offer_tag_ids' => ['nullable', 'array'],
            'offer_tag_ids.*' => ['integer', 'min:1'],
            'page' => ['nullable', 'integer'],
        ];
    }
}
