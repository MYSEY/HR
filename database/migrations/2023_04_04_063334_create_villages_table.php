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
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('phum_name_km')->nullable();
            $table->string('phum_name_latin')->nullable();
            $table->string('phum_name_en')->nullable();
            $table->string('name_km')->nullable();
            $table->string('name_latin')->nullable();
            $table->string('name_en')->nullable();
            $table->string('full_name_km')->nullable();
            $table->string('full_name_latin')->nullable();
            $table->string('full_name_en')->nullable();
            $table->string('commune_id')->nullable();
            $table->string('district_id')->nullable();
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
        Schema::dropIfExists('villages');
    }
};
