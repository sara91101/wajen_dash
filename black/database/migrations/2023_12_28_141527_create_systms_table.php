<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('systms', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string("system_name_ar");
            $table->string("system_name_en")->nullable();
            $table->text("url")->nullable();
            $table->text("endPoint_url")->nullable();
            $table->timestamps();
        });

        DB::table('systms')->insert([
            'system_name_ar' => 'سكيل تاكس',
            'system_name_en' => 'SkilTax',
            'endPoint_url' => 'https://backend.skilltax.sa/api/v1',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('systms');
    }
};
