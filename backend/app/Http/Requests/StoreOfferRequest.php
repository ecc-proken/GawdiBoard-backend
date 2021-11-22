<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:50'],
            'target' => ['nullable', 'string', 'max:255'],
            'job' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
            'picture' => ['nullable', 'url',    'max:255'],
            'link' => ['nullable', 'string', 'max:300'],
            'user_class' => ['required', 'string', 'max:10'],
            'end_date' => ['required', 'after::today', 'date_format:"Y-m-d"'],
            'offer_tag_ids' => ['nullable', 'array'],
            'offer_tag_ids.*' => ['integer',  'min:1'],
        ];
    }
}
