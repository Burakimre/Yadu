<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditAvatarRequest extends FormRequest
{
    public function authorize()
    {
        return $this->accountId == Auth::id();
    }

    public function rules()
    {
        return [
            'accountId' => ['required'],
            'avatar' => ['required', 'mimes:jpeg,jpg,png', 'dimensions:ratio=1/1,max_width=500,max_height=500', 'max:10240']
        ];
    }


}
