<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('srok_name_km')->nullable();
            $table->string('srok_name_latin')->nullable();
            $table->string('srok_name_en')->nullable();
            $table->string('name_km')->nullable();
            $table->string('name_latin')->nullable();
            $table->string('name_en')->nullable();
            $table->string('full_name_km')->nullable();
            $table->string('full_name_latin')->nullable();
            $table->string('full_name_en')->nullable();
            $table->string('province_id')->nullable();
            $table->string('address_km')->nullable();
            $table->string('address_latin')->nullable();
            $table->string('address_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
};
