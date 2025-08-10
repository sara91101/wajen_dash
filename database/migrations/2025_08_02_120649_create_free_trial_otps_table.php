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
        Schema::create('free_trial_otps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone');
            $table->string('otp');
            $table->dateTime('valid_until');
            $table->boolean('used')->default(0);
            $table->string('ip_address');
            $table->string('status')->default('Not-completed');
            $table->string('membership_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_trial_otps');
    }
};
