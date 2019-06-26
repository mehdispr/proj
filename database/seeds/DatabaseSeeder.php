<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(AdminSeeder::class);
        $this->call(ProjetSeeder::class);
        $this->call(DocCommentsSeeder::class);
        $this->call(PaiementSeeder::class);
        $this->call(DonSeeder::class);
    }
}