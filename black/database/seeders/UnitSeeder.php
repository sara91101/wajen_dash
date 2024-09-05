<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            ['ar_name' => 'كيلو جرام', 'en_name' => 'Kilogram', 'abbreviation' => 'kg', 'conversion_factor' => 1.0],
            ['ar_name' => 'جرام', 'en_name' => 'Gram', 'abbreviation' => 'g', 'conversion_factor' => 1000.0],
            ['ar_name' => 'لتر', 'en_name' => 'Liter', 'abbreviation' => 'L', 'conversion_factor' => 1.0],
            ['ar_name' => 'ملي لتر', 'en_name' => 'Milliliter', 'abbreviation' => 'mL', 'conversion_factor' => 1000.0],

        ]);
    }
}
