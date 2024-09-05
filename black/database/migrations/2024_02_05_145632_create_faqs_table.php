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
        Schema::create('faqs', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->foreignId("systm_id")->constrained('systms')->default(1)->onDelete('cascade');
            $table->string("ar_question");
            $table->longText("ar_answer");
            $table->string("en_question");
            $table->longText("en_answer");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
