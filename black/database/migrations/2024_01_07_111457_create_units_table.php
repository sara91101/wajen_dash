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
        Schema::create('units', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string("ar_name");
            $table->string("en_name")->nullable();
            $table->boolean('status')->default(1);
            $table->string('abbreviation')->nullable();
            $table->decimal('conversion_factor', 10, 2)->default(1.0);
            $table->boolean('is_archived')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
