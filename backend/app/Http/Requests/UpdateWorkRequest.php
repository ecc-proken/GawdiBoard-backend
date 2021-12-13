<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkRequest extends FormRequest
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
            'work_id' => ['required', 'integer'],
            'title' => ['nullable', 'string', 'max:50'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
            'picture' => ['nullable', 'url', 'max:255'],
            'link' => ['nullable', 'string', 'max:300'],
            'work_tag_ids' => ['nullable', 'array'],
            'work_tag_ids.*' => ['integer', 'min:1'],
        ];
    }
}
