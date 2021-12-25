<?php

namespace Database\Seeders;

use App\Models\UserModel;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total = 100;
        $faker = Faker::create();

        foreach (range(1, $total) as $index) {
            UserModel::query()->create([
                'name' => $faker->name,
                'surname' => $faker->name,
                'email' => $faker->email,
                'password' => app('hash')->make(123456),
            ]);
        }
    }
}
