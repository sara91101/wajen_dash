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
        Schema::create('friends', function (Blueprint $table)
        {
            $table->bigIncrements("id");
            $table->string("friend_first_name");
            $table->string("friend_last_name");
            $table->string("friend_phone");
            $table->string("friend_email")->nullable();
            $table->string("subscriber_fullname");
            $table->string("subscriber_business_name");
            $table->string("subscriber_activity");
            $table->string("subscriber_phone");
            $table->string("subscriber_email")->nullable();
            $table->string("ip_address");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
