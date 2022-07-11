<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccountRolesTableSeeder::class);
        $this->call(GendersTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(EventTagsTableSeeder::class);
        $this->call(EventPicturesTableSeeder::class);
        $this->call(ProhibitedWordsTableSeeder::class);
        $this->call(AccountSettingsTableSeeder::class);
        $this->call(SocialmediaTableSeeder::class);
        $this->call(SocialMediaPlatformsTableSeeder::class);
    }
}
