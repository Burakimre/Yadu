<?php

use Illuminate\Database\Seeder;

class SocialMediaPlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platforms = array("twitter", "facebook", "whatsapp", "link");

        foreach ($platforms as $platform)
        {
            DB::table('social_media_platforms')->insert([
                'platform' => $platform,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
