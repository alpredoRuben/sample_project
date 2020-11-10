<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'code' => '101',
                'name' => 'ASUS NOTEBOOK',
                'description' => '',
                'category_id' => 1,
                'user_id' => 1,
            ],
            [
                'code' => '102',
                'name' => 'LENOVO NOTEBOOK',
                'description' => '',
                'category_id' => 1,
                'user_id' => 1,
            ],
            [
                'code' => '103',
                'name' => 'TOSHIBA NOTEBOOK',
                'description' => '',
                'category_id' => 1,
                'user_id' => 1,
            ],
        ];

        foreach ($products as $value) {
            Product::create($value);
        }
    }
}
