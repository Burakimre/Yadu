<?php

use Illuminate\Database\Seeder;
use App\socialmedia;

class SocialmediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socialmedia = [
            'linkedin'=>'https://nl.linkedin.com/in/carmentoelen',
            'twitter'=>'https://twitter.com/_Yadu_',
            'facebook'=>'https://www.facebook.com/yadu.nu/?ref=bookmarks',
            'instagram'=>'https://www.instagram.com/yadu.nu/',
            'email'=>'info@YADU.nu',
        ];
        foreach($socialmedia as $name => $link) {
            if($name == "email"){
                DB::table('socialmedia')->insert([
                    'name' => $name,
                    'link' => $link,
                    'type' => "email"
                ]);
            }
            else {
                DB::table('socialmedia')->insert([
                    'name' => $name,
                    'link' => $link,
                ]);
            }
        }
    }
}