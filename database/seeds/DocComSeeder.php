<?php

use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use Illuminate\Support\Facades\DB;

class DocComSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();
        DB::table('documents')->delete();
        foreach (range(1,300) as $i) {
            DB::table('documents')->insert([
                'projet_id'=>rand(1,100),
                'type'=>$faker->randomElement($array = array('photo','analyse','ordonnance','document','affiche','demmande')),
                'description'=>$f->paragraphs($nb = 3, $asText = false)
            ]);
        }
        DB::table('commentaires')->delete();
        foreach (range(1,300) as $i) {
            DB::table('commentaires')->insert([
                'projet_id'=>rand(1,100),
                'user_id'=>rand(1,100),
                'date'=>$f->randomElement($array=array('2019-06-26','2019-06-10','2019-05-22','2019-06-01','2019-05-30','2019-06-25')),
                'texte'=>$f->paragraphs($nb = 1, $asText = false)
            ]);
        }
    }
}
