<?php

namespace App\Http\Requests;

use App\Rules\matchesDatabasePassword;
use const http\Client\Curl\AUTH_ANY;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'currentPassword' => ['required', new matchesDatabasePassword()],
            'newPassword' => ['required', 'string', 'min:8','confirmed']
        ];
    }
}
