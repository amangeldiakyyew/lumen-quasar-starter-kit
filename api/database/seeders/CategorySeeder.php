<?php

namespace Database\Seeders;

use App\Models\CategoryModel;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total = 32;
        $faker = Faker::create();

        $i = 0;
        foreach (range(1, $total) as $index) {
            $i++;
            $data = [
                'name' => $faker->name,
                'description' => $faker->name . ' ' . $faker->name . ' ' . $faker->name,
                'price' => 0,
                'sort_order' => $i,
                'product_addable' => 0,
            ];
            $category = CategoryModel::query()->create($data);
            if ($category) {
                $ii=0;
                foreach (range(1, 5) as $indx) {
                    $ii++;
                    $chData = [
                        'parent_id' => $category->id,
                        'name' => $faker->name,
                        'description' => $faker->name . ' ' . $faker->name . ' ' . $faker->name,
                        'price' => 0,
                        'sort_order' => $ii,
                        'product_addable' => 1,
                    ];
                    $chCategory = CategoryModel::query()->create($chData);
                    if ($chCategory) {
                        $iii=0;
                        foreach (range(1, 5) as $ndx) {
                            $iii++;
                            $gchData = [
                                'parent_id' => $chCategory->id,
                                'name' => $faker->name,
                                'description' => $faker->name . ' ' . $faker->name . ' ' . $faker->name,
                                'price' => 0,
                                'sort_order' => $iii,
                                'product_addable' => 1,
                            ];
                            CategoryModel::query()->create($gchData);
                        }
                    }
                }
            }
        }
    }
}
