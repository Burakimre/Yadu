<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProhibitedWordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'updatedProhibitedWord' => [
                'required',
                'unique:prohibited_words,word',
                'min:1',
                'max:45',
                'string',
                'regex:^[a-z0-9]+$^'],

            'originalProhibitedWord' => [
                'required',
                'exists:prohibited_words,word',
                'min:1',
                'max:45',
                'string',
                'regex:^[a-z0-9]+$^'],
        ];
    }
}
