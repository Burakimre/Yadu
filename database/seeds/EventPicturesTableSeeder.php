<?php

use Illuminate\Database\Seeder;
use App\Traits\CrossEnvironmentDirectoryNames;

class EventPicturesTableSeeder extends Seeder
{
    use CrossEnvironmentDirectoryNames;
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //factory('App\EventPicture', 10)->create();

        //Do not change the order of these
        //Amount can not be higher than the amount of images in the specified directory
        //Images need to be .jpg

        $this->seedCategory("uitje_met_gezinnen", 16, 1);
        $this->seedCategory("eten", 15, 2);
        $this->seedCategory("borrelen", 16, 3);
        $this->seedCategory("koffie", 11, 4);
        $this->seedCategory("wandelen", 15, 5);
        $this->seedCategory("uitje_in_stad", 14, 6);
        $this->seedCategory("museum", 17, 7);
        $this->seedCategory("theater_film", 16, 8);
        $this->seedCategory("evenementen", 16, 9);
        $this->seedCategory("alles_wat", 19, 10);
        $this->seedCategory("sporten", 19, 11);
        $this->seedCategory("op_wielen", 17, 12);
    }

    private function seedCategory(string $directory, int $amount, int $tag_id){
        $directoryPath = public_path() . "/images/seeder/eventpictures/" . $directory . "/";
        $directoryPath = $this->FormatDirectoryName("/", $directoryPath);

        for ($i=1; $i <= $amount; $i++) {
            $filePath = $directoryPath . $i . ".jpg";

            DB::table('event_pictures')->insert([
                'tag_id' => $tag_id,
                'picture' => fread(fopen($filePath , "r"), filesize($filePath)),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
