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
                'donateur_id'=>rand(1,30),
                'projet_id'=>rand(1,100),
                'hide'=>$f->randomElement($array=array(true,false)),
            ]);
        }
    }
}
