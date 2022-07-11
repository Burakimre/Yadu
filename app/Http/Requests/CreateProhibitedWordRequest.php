<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProhibitedWordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'newProhibitedWord' => [
                'required',
                'unique:prohibited_words,word',
                'min:1',
                'max:45',
                'string',
                'regex:^[a-z0-9]+$^']
        ];
    }
}
