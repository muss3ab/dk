<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'content' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'The content field is required.',
        ];
    }
}
