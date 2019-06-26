<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = faker::create();
        DB::table('paiements')->delete();
        foreach (range(1,600) as $i) {
            DB::table('paiements')->insert([
                'donateur_id'=>rand(1,30),
                'methode'=>$f->randomElement($array=array('online','check','virement','cash')),
                'date'=>$f->randomElement($array=array('2019-06-26','2019-06-10','2019-05-22','2019-06-01','2019-05-30','2019-06-25')),
                'montant'=>rand(40,60000),
                'status'=>$f->randomElement($array=array('accepter','accepter')),
            ]);
        }
    }
}
