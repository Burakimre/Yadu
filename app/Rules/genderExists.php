<?php

namespace App\Rules;

use App\Gender;
use Illuminate\Contracts\Validation\Rule;

class genderExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $gender)
    {
        if ($gender == "-"){
            return true;
        }

        $genderMatches = Gender::where('gender', $gender)->count();
        return ($genderMatches > 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.genderExists');
    }
}
