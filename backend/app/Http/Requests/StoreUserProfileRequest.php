<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        # TODO:認証ができたらfalseにする
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
            'student_number' => ['required', 'integer', 'digits:7'], #数値かつ7桁
            'user_name' => ['required', 'string', 'max:50'],
            'link' => ['required', 'url', 'max:255'],
            'self_introduction' => ['required', 'string',    'max:255'],
        ];
    }
}
