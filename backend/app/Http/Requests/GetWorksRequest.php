<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetWorksRequest extends FormRequest
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
            'work_tag_ids' => ['nullable', 'array'],
            'work_tag_ids.*' => ['integer', 'min:1'],
            'page' => ['nullable', 'integer'],
        ];
    }
}
