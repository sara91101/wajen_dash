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
        Schema::create('customers', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string("membership_no")->nullable();

            $table->string("first_name");
            $table->string("second_name");
            $table->string("bussiness_name")->nullable();

            $table->string("tax_no");
            $table->string("phone");
            $table->string("email");

            $table->date("start_date");
            $table->date("end_date");
            $table->string("url")->nullable();

            $table->decimal("amount");
            $table->decimal("taxes")->nullable();
            $table->integer("taxes_type")->comment("1=value,2=percentage")->default(1);
            $table->decimal("discounts")->nullable();
            $table->integer("discounts_type")->comment("1=value,2=percentage")->default(1);
            $table->decimal("final_amount");

            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->foreignId('systm_id')->constrained('systms')->onDelete('cascade');
            $table->foreignId('governorate_id')->constrained('governorates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
