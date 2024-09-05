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
        Schema::create('sub_page_operations', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->foreignId('sub_page_id')->constrained('sub_pages')->onDelete('cascade');
            $table->string("operation");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_page_operations');
    }
};
