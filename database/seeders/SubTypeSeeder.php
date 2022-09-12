<?php

namespace Database\Seeders;
use App\Models\CouponSubtype;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subtypes = [
            [
                'subtype_name' => '%off'
            ],
            [
                'subtype_name' => 'flat'
            ],
            [
                'subtype_name' => 'free'
            ]
        ];

        foreach ($subtypes as $key => $value) {
            CouponSubtype::create($value);
        }
    }
}
