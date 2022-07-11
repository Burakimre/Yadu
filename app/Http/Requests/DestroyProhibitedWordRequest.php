<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyProhibitedWordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prohibitedWordToDelete' => [
                'required',
                'exists:prohibited_words,word'
            ]
        ];
    }
}
