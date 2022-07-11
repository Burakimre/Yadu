<?php

use Illuminate\Database\Seeder;

class EventTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePathDefault = public_path() . "/images/seeder/eventtags/uitje_met_gezinnen.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/uitje_met_gezinnen_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Uitje met gezinnen',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/eten.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/eten_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Eten',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/borrelen.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/borrelen_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Borrelen',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/koffie.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/koffie_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Koffie',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/wandelen.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/wandelen_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Wandelen',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/uitje_in_stad.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/uitje_in_stad_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Uitje in stad',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/museum.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/museum_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Museum',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/theater_film.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/theater_film_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Theater/film',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/evenementen.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/evenementen_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Evenementen',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/van_alles_wat.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/van_alles_wat_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Van alles wat',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/sporten.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/sporten_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Sporten',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);

        $filePathDefault = public_path() . "/images/seeder/eventtags/op_wielen.png";
        $filePathSelected = public_path() . "/images/seeder/eventtags/op_wielen_1.png";

        DB::table('event_tags')->insert([
            'tag' => 'Op wielen',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'imageDefault' => fread(fopen($filePathDefault , "r"), filesize($filePathDefault)),
            'imageSelected' => fread(fopen($filePathSelected , "r"), filesize($filePathSelected))
        ]);
    }
}
