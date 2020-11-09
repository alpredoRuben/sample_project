<?php

use Illuminate\Database\Seeder;
use App\Models\Classification;

class ClassificationTableSeeder extends Seeder
{
    public function getClassification()
    {
        return [
            'numeric',
            'text',
            'listed',
            'condition'
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getClassification() as $classed) {
            Classification::create([
                'type_name' => $classed
            ]);
        }
    }
}
