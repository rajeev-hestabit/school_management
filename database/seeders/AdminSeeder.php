<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User_profile;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' =>
                '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $users = DB::table('users')
            ->select(DB::raw('id'))
            // ->where('role', 'Student')
            ->get();

        $i = 0;
        foreach ($users as $user) {
            User_profile::create([
                'user_id' => $user->user_id,
                'profile_picture' => $this->faker->imageUrl(
                    $width = 200,
                    $height = 200
                ),
                'role' => 'Admin',
                'current_school' => $this->faker->company(),
                'previous_school' => $this->faker->company(),
                'assigned_teacher' => $this->faker->name(),
                'teacher_experience' => $this->faker->randomDigit(),
                'is_approved' => false,
            ]);
        }
    }
}
