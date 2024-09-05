<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('months')->insert([
            ['month' => 'يناير'],
            ['month' => 'فبراير',],
            ['month' => 'مارس', ],
            ['month' => 'أبريل'],

            ['month' => 'مايو'],
            ['month' => 'يونيو',],
            ['month' => 'يوليو', ],
            ['month' => 'أغسطس'],

            ['month' => 'سبتمبر'],
            ['month' => 'أكتوبر',],
            ['month' => 'نوفمبر', ],
            ['month' => 'ديسمبر'],

        ]);
    }
}
