<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker;
use App\Models\Parents_detail;

class Parents_detailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = DB::table('users')
            ->select(DB::raw('id'))
            //->where('role', 'Student')
            ->get();

        $i = 0;
        foreach ($users as $user) {
            Parents_detail::create([
                'user_id' => $user->id,
                'father_name' => $faker->name(),
                'mother_name' => $faker->name(),
                'father_occupation' => $faker->name(),
                'mother_occupation' => $faker->name(),
                'father_contact_no' => $faker->phoneNumber(),
                'mother_contact_no' => $faker->phoneNumber(),
            ]);
        }
    }
}
