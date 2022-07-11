<?php

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'accountRole' => 'Admin',
            'email' => 'admin@yadu.nu',
            'password' => Hash::make('password'),
            'doForcePasswordChange' => 1,
            'firstName' => encrypt('Admin'),
            'middleName' => encrypt(null),
            'lastName' => encrypt(null),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'api_token' => str_random(60),
        ]);
    }
}
