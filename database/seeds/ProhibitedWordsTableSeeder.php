<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProhibitedWordsTableSeeder extends Seeder
{
    public function run()
    {
        $words = array(
            "Kut",
            "Fuck",
            "Nigger",
            "Hoer",
            "Lul",
            "Piemel",
            "Tering",
            "Tiefus",
            "Kanker",
            "Aids",
            "Bitch",
            "Asshole",
            "Motherfucker",
            "Dick",
            "Cunt",
            "Whore",
            "Klootzak",
            "Mongool",
            "Slet",
            "Kutwijf",
            "tseries",
            "t-series",
        );

        foreach($words as $word) {
            DB::table('prohibited_words')->insert([
                'word' => $word,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]);
        }
    }
}
