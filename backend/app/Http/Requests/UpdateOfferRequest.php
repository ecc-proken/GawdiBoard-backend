<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            'offer_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:100'],
            'target' => ['present', 'string', 'max:255'],
            'job' => ['present', 'string', 'max:255'],
            'note' => ['present', 'string', 'max:1000'],
            'picture' => ['present', 'url',    'max:255'],
            'link' => ['present', 'string', 'max:300'],
            'user_class' => ['required', 'string', 'max:10'],
            'end_date' => ['required', 'after::today', 'date_format:"Y-m-d"', 'before_or_equal:now +30 day'],
            'offer_tag_ids' => ['required', 'array'],
            'offer_tag_ids.*' => ['integer',  'min:1'],
        ];
    }
}
