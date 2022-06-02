<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(10)->create();

        //Address::factory(10)->create();
        $this->call([
            User_profileSeeder::class,
            //AdminSeeder::class,
            AddressSeeder::class,
            Parents_detailSeeder::class,
            SubjectSeeder::class,
        ]);
    }
}
