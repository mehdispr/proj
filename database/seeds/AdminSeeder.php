<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Faker\Factory as faker;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = faker::create();
        DB::table('admins')->delete();
        foreach (range(1,10) as $i) {
            DB::table('admins')->insert([
                'nom'=>$faker->firstName,
                'prenom'=>$faker->lastName,
                'cin'=>$faker->regexify('[A-Z]{2}[0-9]{4}'),
                'ville'=>$faker->city,
                'adresse'=>$faker->address,
                'zip'=>$faker->postcode,
                'tel'=>$faker->phoneNumber,
                'email'=>$faker->email,
                'mdp'=>$faker->randomNumber($nbDigits = NULL, $strict = false),
                ]);
        }

        DB::table('moderateurs')->delete();
        foreach (range(1,10) as $i) {
            DB::table('moderateurs')->insert([
                'nom'=>$faker->firstName,
                'prenom'=>$faker->lastName,
                'cin'=>$faker->regexify('[A-Z]{2}[0-9]{4}'),
                'ville'=>$faker->city,
                'adresse'=>$faker->address,
                'zip'=>$faker->postcode,
                'tel'=>$faker->phoneNumber,
                'email'=>$faker->email,
                'mdp'=>$faker->randomNumber($nbDigits = NULL, $strict = false),
                ]);
        }

        DB::table('demandeurs')->delete();
        foreach (range(1,50) as $i) {
            DB::table('demandeurs')->insert([
                'nom'=>$faker->firstName,
                'prenom'=>$faker->lastName,
                'cin'=>$faker->regexify('[A-Z]{2}[0-9]{4}'),
                'ville'=>$faker->city,
                'adresse'=>$faker->address,
                'zip'=>$faker->postcode,
                'tel'=>$faker->phoneNumber,
                'email'=>$faker->email,
                'mdp'=>$faker->randomNumber($nbDigits = NULL, $strict = false),
                ]);
        }

        
        DB::table('donateurs')->delete();
        foreach (range(1,30) as $i) {
            DB::table('donateurs')->insert([
                'nom'=>$faker->firstName,
                'prenom'=>$faker->lastName,
                'cin'=>$faker->regexify('[A-Z]{2}[0-9]{4}'),
                'ville'=>$faker->city,
                'adresse'=>$faker->address,
                'zip'=>$faker->postcode,
                'tel'=>$faker->phoneNumber,
                'email'=>$faker->email,
                'mdp'=>$faker->randomNumber($nbDigits = NULL, $strict = false),
                ]);
        }


    }
}
