<?php

use Illuminate\Database\Seeder;
use App\Models\ProductClassification;
use App\Models\Classification;

class ProductClassificationSeeder extends Seeder
{
    public function getProductClass()
    {
        return [
            [
                'name' => 'Warna',
                'value' => 'Red,Green,Blue,White,Black,Light Grey,Silver,Gray,Maroon,Aqua,Cyan,Light White',
                'type' => 'listed'
            ],
            [
                'name' => 'Layar',
                'value' => '10,11,14,15,18,20,22,29,32',
                'type' => 'listed'
            ],
            [
                'name' => 'Discount',
                'value' => 'Free Ongkir,Cashback,Star Point',
                'type' => 'listed'
            ],
            [
                'name' => 'Status',
                'value' => '1',
                'type' => 'condition'
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
        $productClasses = $this->getProductClass();

        foreach ($productClasses as $value) {
            $classification = Classification::where('type_name', $value['type'])->first();

            ProductClassification::create([
                'classification_id' => $classification->id,
                'name' => $value['name'],
                'value' => $value['value'],
            ]);
        }
    }
}
