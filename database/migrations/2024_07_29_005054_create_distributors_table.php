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
        Schema::create('distributors', function (Blueprint $table)
        {
            $table->bigIncrements("id");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("business_name");
            $table->string("phone");
            $table->string("email");
            $table->string("city");
            $table->string("branches_no");
            $table->string("ip_address");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};
