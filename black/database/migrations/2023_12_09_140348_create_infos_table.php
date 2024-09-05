<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('infos', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string("name_ar");
            $table->string("name_en");
            $table->string("address_ar");
            $table->string("address_en");
            $table->string("phone");
            $table->string("email");
            $table->string("logo");
            $table->string("bill");
            $table->timestamps();
        });

        DB::table('infos')->insert([
            'name_en'=> "WAJEN",
            'name_ar'=> "وﺟﻴﻦ ﻟﺘﻘﻨﻴﺔ اﻟﻤﻌﻠﻮﻣﺎت",
            'logo'=> "/imgs/logo.jpeg",
            'bill'=> "/imgs/WhatsApp Image 2023-07-01 at 2.29.18 PM.jpeg",
            'phone'=> "+966506963328",
            'email'=> "wajen@wajen.sa",
            'address_ar'=> "تبوك, العليا, طريق الامير فهر بن سلطان",
            'address_en'=>"tabuk, alolya, fahad bin sultan Rode"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
