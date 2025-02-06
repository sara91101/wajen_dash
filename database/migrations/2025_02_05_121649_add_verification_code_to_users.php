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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->after('email')->nullable();
            $table->string('verification_code')->after('phone_number')->nullable();
            $table->timestamp('valid_until')->after('verification_code')->nullable();
            $table->boolean('code_used')->after('valid_until')->default(0);
            $table->boolean('verified')->after('code_used')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
