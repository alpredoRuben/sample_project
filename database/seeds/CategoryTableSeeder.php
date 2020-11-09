<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    public function getCategories()
    {
        return [
            [
                'name' => 'Laptop',
                'description' => ''
            ],
            [
                'name' => 'Personal Computer',
                'description' => ''
            ],
            [
                'name' => 'Aksesoris Computer',
                'description' => ''
            ],
        ];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = $this->getCategories();

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
