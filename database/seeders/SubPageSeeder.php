<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_pages')->insert([
            ['page_id' => 1, 'sub_page' => 'عرض'],
            ['page_id' => 1, 'sub_page' => 'إضافة'],
            ['page_id' => 1, 'sub_page' => 'تعديل'],
            ['page_id' => 1, 'sub_page' => 'حذف'],

            ['page_id' => 2, 'sub_page' => 'عرض'],
            ['page_id' => 2, 'sub_page' => 'إضافة'],
            ['page_id' => 2, 'sub_page' => 'تعديل'],
            ['page_id' => 2, 'sub_page' => 'حذف'],
            ['page_id' => 2, 'sub_page' => 'مراسلة'],

            ['page_id' => 3, 'sub_page' => 'عرض'],
            ['page_id' => 3, 'sub_page' => 'إضافة'],
            ['page_id' => 3, 'sub_page' => 'تعديل'],
            ['page_id' => 3, 'sub_page' => 'حذف'],

            ['page_id' => 4, 'sub_page' => 'عرض'],
            ['page_id' => 4, 'sub_page' => 'إضافة'],
            ['page_id' => 4, 'sub_page' => 'تعديل'],
            ['page_id' => 4, 'sub_page' => 'حذف'],

            ['page_id' => 5, 'sub_page' => 'عرض'],
            ['page_id' => 5, 'sub_page' => 'إضافة'],
            ['page_id' => 5, 'sub_page' => 'تعديل'],
            ['page_id' => 5, 'sub_page' => 'حذف'],

            ['page_id' => 6, 'sub_page' => 'عرض'],
            ['page_id' => 6, 'sub_page' => 'إضافة'],
            ['page_id' => 6, 'sub_page' => 'تعديل'],
            ['page_id' => 6, 'sub_page' => 'حذف'],

            ['page_id' => 7, 'sub_page' => 'عرض'],
            ['page_id' => 7, 'sub_page' => 'تعديل'],

            ['page_id' => 8, 'sub_page' => 'عرض'],
            ['page_id' => 8, 'sub_page' => 'إضافة'],
            ['page_id' => 8, 'sub_page' => 'تعديل'],
            ['page_id' => 8, 'sub_page' => 'حذف'],

            ['page_id' => 9, 'sub_page' => 'عرض'],
            ['page_id' => 9, 'sub_page' => 'إضافة'],
            ['page_id' => 9, 'sub_page' => 'تعديل'],
            ['page_id' => 9, 'sub_page' => 'حذف'],

            ['page_id' => 10, 'sub_page' => 'عرض'],
            ['page_id' => 10, 'sub_page' => 'إضافة'],
            ['page_id' => 10, 'sub_page' => 'تعديل'],
            ['page_id' => 10, 'sub_page' => 'حذف'],

            ['page_id' => 11, 'sub_page' => 'عرض'],
            ['page_id' => 11, 'sub_page' => 'إضافة'],
            ['page_id' => 11, 'sub_page' => 'تعديل'],
            ['page_id' => 11, 'sub_page' => 'حذف'],

            ['page_id' => 12, 'sub_page' => 'عرض'],
            ['page_id' => 12, 'sub_page' => 'حذف'],

            ['page_id' => 13, 'sub_page' => 'عرض'],
            ['page_id' => 13, 'sub_page' => 'إضافة'],
            ['page_id' => 13, 'sub_page' => 'تعديل'],
            ['page_id' => 13, 'sub_page' => 'حذف'],

            ['page_id' => 14, 'sub_page' => 'عرض'],
            ['page_id' => 14, 'sub_page' => 'إضافة'],
            ['page_id' => 14, 'sub_page' => 'تعديل'],
            ['page_id' => 14, 'sub_page' => 'حذف'],

            ['page_id' => 15, 'sub_page' => 'إحصائية المشتركين بالنظام'],
            ['page_id' => 15, 'sub_page' => 'إحصائية المشتركين بالمٌدٌن'],
            ['page_id' => 15, 'sub_page' => 'إحصائية المشتركين بالمحافظات'],
            ['page_id' => 15, 'sub_page' => 'إحصائية المشتركين بالباقات'],
            ['page_id' => 15, 'sub_page' => 'إحصائية المشتركين بالإشتراك'],


            ['page_id' => 16, 'sub_page' => 'تغيير كلمة المرور'],
        ]);
    }
}
