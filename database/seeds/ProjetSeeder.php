<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;

class ProjetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = faker::create();
        DB::table('projets')->delete();
        foreach (range(1,100) as $i) {
            $price= $f->numberBetween($min=1000, $max=1000000);
            $rest= $price - $f->numberBetween($min=1000, $max=9999);

            DB::table('projets')->insert([
                'demandeur_id'=>rand(1,50),
                'moderateur_id'=>rand(1,10),
                'titre'=>$f->realText($maxNbChars = 15, $indexSize = 1),
                'categorie'=>$f->randomElement($array = array ('reve','maladie','projet','religion')),
                'montant'=>$price,
                'restant'=>$rest,
                'date_debut'=>$f->date($format = 'Y-m-d', $min = 'now'),
                'description'=>$f->realText($maxNbChars = 400, $indexSize = 4),
                'visited'=>rand(0,100)
            ]);
        }
    }
}
