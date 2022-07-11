<?php

namespace App\Http\Requests;

use App\Gender;
use App\Rules\emailUniqueExceptSelf;
use App\Rules\genderExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditPrivacySettingsRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'followerVisibility' => ['required', 'regex:^(private|public|follower)$^'],
            'followingVisibility' => ['required', 'regex:^(private|public|follower)$^'],
            'infoVisibility' => ['required', 'regex:^(private|public|follower)$^'],
            'eventsVisibility' => ['required', 'regex:^(private|public|follower)$^'],
            'participatingVisibility' => ['required', 'regex:^(private|public|follower)$^'],
        ];
    }
}




