<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'promotion_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:50'],
            'note' => ['present', 'string', 'max:255'],
            'picture' => ['present', 'url',    'max:255'],
            'link' => ['present', 'string', 'max:300'],
            'user_class' => ['required', 'string', 'max:10'],
            'end_date' => ['required', 'after::today', 'date_format:"Y-m-d"', 'before_or_equal:now +90 day'],
            'promotion_tag_ids' => ['required', 'array'],
            'promotion_tag_ids.*' => ['integer',  'min:1'],
        ];
    }
}
