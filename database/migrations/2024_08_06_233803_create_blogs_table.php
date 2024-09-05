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
        Schema::create('blogs', function (Blueprint $table)
        {
            $table->bigIncrements("id");
            $table->foreignId('department_id')->constrained('blog_departments')->onDelete('cascade');
            $table->longText("ar_title");
            $table->longText("en_title")->nullable();
            $table->longText("ar_details");
            $table->longText("en_details")->nullable();
            $table->longText("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
