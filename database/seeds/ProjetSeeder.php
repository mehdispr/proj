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
            $price= $f->randomElement($array = array (6000,841050,10000,23600,40000,45200,64125));
            $pr = $f->randomElement($array = array (45,26,75,10,5,84,36,60,31,44,97));
            $rest= $price - (($price*$pr)/100);

            $dd=$f->date($format = 'Y-m-d', $min = '2017-12-01');
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
