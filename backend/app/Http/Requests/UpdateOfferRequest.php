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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'offer_id'   => ['required', 'integer'],
            'title'      => ['required', 'string', 'max:50'],
            'target'     => ['nullable', 'string', 'max:255'],
            'job'        => ['nullable', 'string', 'max:255'],
            'note'       => ['nullable', 'string', 'max:255'],
            'picture'    => ['nullable', 'url',    'max:255'],
            'link'       => ['nullable', 'string', 'max:300'],
            'user_class' => ['required', 'string', 'max:10'],
            'end_date'   => ['required', 'date_format:"Y-m-d"'],
            'offer_tags' => ['nullable', 'array'],
        ];
    }
}
