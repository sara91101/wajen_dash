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
        Schema::create('minors', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string("minor_ar");
            $table->string("minor_en")->nullable();
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minors');
    }
};
