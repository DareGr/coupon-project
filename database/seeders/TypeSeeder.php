<?php

namespace Database\Seeders;
use App\Models\CouponType;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'type_name' => 'single'
            ],
            [
                'type_name' => 'multi-limit'
            ],
            [
                'type_name' => 'single-expires'
            ],
            [
                'type_name' => 'multi-expires'
            ],
            [
                'type_name' => 'unlimited'
            ]
        ];

        foreach ($types as $key => $value) {
            CouponType::create($value);
        }
    }
}
