<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\ProhibitedWord;

class swearWords implements Rule
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
    public function passes($attribute, $value)
    {
        $ProhibitedWords = ProhibitedWord::all()->pluck('word');
        foreach ($ProhibitedWords as $ProhibitedWord) {
            if (strpos(strtolower($value), strtolower($ProhibitedWord)) !== false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.swearWords');
    }
}