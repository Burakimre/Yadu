<?php

use Illuminate\Database\Seeder;

class AccountSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_settings')->insert([
            'account_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
