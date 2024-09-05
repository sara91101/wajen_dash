<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('level_sub_pages', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->foreignId('sub_page_id')->constrained('sub_pages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_sub_pages');
    }
};
