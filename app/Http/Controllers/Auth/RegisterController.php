<?php

namespace App\Http\Controllers\Auth;

use App\Account;
use App\AccountSettings;
use App\Rules\genderExists;
use App\Http\Controllers\Controller;
use App\Mail\Confirmation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Rules\swearWords;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function showRegistrationForm()
    {
        $genders = \App\Gender::all();

        return view('auth.register')->with('genders', $genders);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [

            'firstName' => ['required','min:1','max:45','string', new swearWords],
            'middleName' => ['nullable', 'max:45','string'],
            'lastName' => ['nullable', 'max:45','string'],
            'dateOfBirth' => ['nullable', 'date'],
            'gender' => new genderExists,
            'email' => ['required', 'string', 'email', 'max:255', 'unique:accounts'],
            'password' => ['required', 'string', 'min:8','confirmed']
        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $account = Account::create([
            'firstName' => $data['firstName'],
            'middleName' => $data['middleName'],
            'lastName' => $data['lastName'],
            'dateOfBirth' => $data['dateOfBirth'],
            'email' => $data['email'],
            'gender' => ($data['gender'] == "-" ? null : $data['gender']),
            'password' => Hash::make($data['password']),
            'api_token' => str_random(60),
        ]);

        return $account;
    }
}
