<?php

namespace App\Rules;

use App\Account;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class emailUniqueExceptSelf implements Rule
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
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $email)
    {
        $accountWithSameEmail = Account::where('email', $email)->first();
        $currentAccount = Account::where('id', Auth::id())->firstOrFail();

        if ($accountWithSameEmail == null) {
            //No duplicate email found
            return true;
        }

        if ($accountWithSameEmail == $currentAccount) {
            //Duplicate mail found, but is from the same user
            return true;
        } else {
            //Duplicate mail found
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique');
    }
}
