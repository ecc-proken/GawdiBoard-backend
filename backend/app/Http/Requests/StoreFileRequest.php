<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
        return [ //TODO: ピクセル：比率にのバリデーションを追加
            'file' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}