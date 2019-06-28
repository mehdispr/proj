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
            $price= $f->numberBetween($min=100000, $max=1000000);
            $rest= $price - $f->randomElement($array = array (8120,451,10752,54231,54521,14000,632305,65000,65656,61003,23002,65665,62325,6226,2251));

            $dd=$f->date($format = 'Y-m-d', $min = 'now');
            $df = date('Y-m-d', strtotime("+1 months", strtotime($dd)));
            DB::table('projets')->insert([
                'demandeur_id'=>rand(1,50),
                'moderateur_id'=>rand(1,10),
                'titre'=>$f->realText($maxNbChars = 15, $indexSize = 1),
                'categorie'=>$f->randomElement($array = array ('reve','maladie','projet','religion')),
                'montant'=>$price,
                'restant'=>$rest,
                'date_debut'=>$dd,
                'date_fin'=>$df,
                'description'=>$f->realText($maxNbChars = 400, $indexSize = 4),
                'visited'=>rand(0,100)
            ]);
        }
    }
}
