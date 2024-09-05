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
        Schema::table('customer_packages', function (Blueprint $table) {
            $table->decimal("taxes")->nullable()->after("price");
            $table->integer("taxes_type")->comment("1=value,2=percentage")->default(1)->after("taxes");
            $table->decimal("discounts")->nullable()->after("taxes_type");
            $table->integer("discounts_type")->comment("1=value,2=percentage")->default(1)->after("discounts");
            $table->decimal("final_amount")->after("discounts_type");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_packages', function (Blueprint $table) {
            //
        });
    }
};
