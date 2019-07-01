<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;
use App\Paiement;

class DonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = faker::create();
        foreach (range(1,300) as $i) {
            DB::table('dons')->insert([
                'paiement_id'=>rand(1,300),
                'projet_id'=>rand(1,100),
                'montant'=>DB::table('paiements')->where('paiement_id',$i)->value('montant'),
                'date'=>$f->randomElement($array=array('2019-06-26','2019-06-10','2019-05-22','2019-06-01','2019-05-30','2019-06-25')),
            ]);
        }
    }
}
