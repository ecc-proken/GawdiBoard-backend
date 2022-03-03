<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'user_name' => ['required', 'string', 'max:50'],
            'link' => ['present', 'url', 'max:255'],
            'self_introduction' => ['present', 'string', 'max:255'],
            'icon' => ['present', 'string', 'max:255'],
        ];
    }
}
