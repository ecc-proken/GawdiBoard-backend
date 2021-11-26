<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostWorkRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'note' => ['required', 'string'],
            'picture' => ['required', 'string'],
            'link' => ['required', 'string'],
            'post_date' => ['required', 'date'],
            'student_number' => ['required', 'digits:5'],
            'user_name' => ['required', 'string'],
            'work_tags' => ['required', 'array'],
        ];
    }
}
