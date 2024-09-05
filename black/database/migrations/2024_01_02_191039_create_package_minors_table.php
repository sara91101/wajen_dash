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
        Schema::create('package_minors', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->foreignId('minor_id')->constrained('minors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_minors');
    }
};
