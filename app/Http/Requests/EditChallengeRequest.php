<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditChallengeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required',
            'value' => 'string|required'
        ];
    }
}
