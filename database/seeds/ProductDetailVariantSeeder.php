<?php

use Illuminate\Database\Seeder;
use App\Models\ProductDetail;
use App\Models\ProductVariant;

class ProductDetailVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productDetails = [
            [
                'product_id' => 1,
                'name' => 'ASUS Laptop A407MA',
                'stock' => 30,
                'price' => 8700000,
                'user_id' => 1,
                'variants' => [
                    [
                        'product_class_id' => 1,
                        'variant_value' => [
                            'Red','Blue','White','Black','Light Grey','Silver'
                        ]
                    ],
                    [
                        'product_class_id' => 2,
                        'variant_value' => [
                            14,15,18,20
                        ]
                    ],
                    [
                        'product_class_id' => 3,
                        'variant_value' => [
                            'Free Ongkir','Cashback','Star Point'
                        ]
                    ],
                ]
            ],
            [
                'product_id' => 1,
                'name' => 'ASUS Laptop 15 X509FJ',
                'stock' => 45,
                'price' => 9350000,
                'user_id' => 1,
                'variants' => [
                    [
                        'product_class_id' => 1,
                        'variant_value' => [
                            'Red','Blue','White','Black','Light Grey','Silver'
                        ]
                    ],
                    [
                        'product_class_id' => 2,
                        'variant_value' => [
                            14,15,18,20
                        ]
                    ],
                    [
                        'product_class_id' => 3,
                        'variant_value' => [
                            'Free Ongkir','Cashback','Star Point'
                        ]
                    ],
                ]
            ],
            [
                'product_id' => 1,
                'name' => 'ASUS Laptop F571GT',
                'stock' => 10,
                'price' => 1100000,
                'user_id' => 1,
                'variants' => [
                    [
                        'product_class_id' => 1,
                        'variant_value' => [
                            'Red','Blue','White','Black','Light Grey','Silver'
                        ]
                    ],
                    [
                        'product_class_id' => 2,
                        'variant_value' => [
                            14,15,18,20
                        ]
                    ],
                    [
                        'product_class_id' => 3,
                        'variant_value' => [
                            'Free Ongkir','Cashback','Star Point'
                        ]
                    ],
                ]
            ],
        ];

        foreach ($productDetails as $item) {
            $PD = ProductDetail::create([
                'product_id' => $item['product_id'],
                'name' => $item['name'],
                'stock' => $item['stock'],
                'price' => $item['price'],
                'user_id' => $item['user_id']
            ]);

            foreach ($item['variants'] as $value) {
                $variant_value = '';
                if (is_array($value['variant_value'])) {
                    $variant_value = json_encode($value['variant_value'], true);
                } else {
                    $variant_value = $value['variant_value'];
                }

                ProductVariant::create([
                    'product_detail_id' => $PD->id,
                    'product_class_id' => $value['product_class_id'],
                    'variant_value' => $variant_value
                ]);
            }
        }
    }
}
