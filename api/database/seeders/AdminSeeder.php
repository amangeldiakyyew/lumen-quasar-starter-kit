<?php

namespace Database\Seeders;

use App\Models\AdminModel;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = AdminModel::query()->where('email', 'amangeldiakyyew@gmail.com')->first();
        if (!$admin) {
            AdminModel::query()->create([
                'email' => 'amangeldiakyyew@gmail.com',
                'username' => 'amangeldiakyyew',
                'password' => app('hash')->make(123456),
                'name' => 'Amangeldi',
                'surname' => 'Akyyev',
            ]);
        } else {
            AdminModel::query()->where('email', 'amangeldiakyyew@gmail.com')->update(['password' => app('hash')->make(123456)]);
        }
    }
}
