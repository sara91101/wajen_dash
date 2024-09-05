<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pages')->insert([
            ['page' => 'الأنظمة'],

            ['page' => 'المشتركين'],

            ['page' => 'الباقات'],
            ['page' => 'القائمة الرئيسية'],
            ['page' => 'القائمة الفرعية'],
            ['page' => 'الخصائص'],

            ['page' => 'من نحن'],
            ['page' => 'المُدُن'],
            ['page' => 'المحافظات'],
            ['page' => 'أنواع النشاط'],
            ['page' => 'وحدات القياس'],
            ['page' => 'الجلسات النشطة'],
            ['page' => 'أنواع المستخدمين'],
            ['page' => 'المستخدمين'],

            ['page' => 'التقارير'],
            ['page' => 'أٌخرى'],
        ]);
    }
}
