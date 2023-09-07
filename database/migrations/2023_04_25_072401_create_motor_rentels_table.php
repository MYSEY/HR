<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_04_25_072401_create_motor_rentels_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motor_rentels', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->decimal('gasoline_price_per_liter')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('product_year')->nullable();
            $table->string('expired_year')->nullable();
            $table->integer('shelt_life')->nullable();
            $table->string('number_plate')->nullable();
            $table->string('motorcycle_brand')->nullable();
            $table->string('category')->nullable();
            $table->string('body_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->integer('total_gasoline')->nullable();
            $table->integer('total_work_day')->nullable();
            $table->decimal('price_engine_oil')->nullable();
            $table->decimal('price_motor_rentel')->nullable();
            $table->string('taplab_rentel')->nullable();
            $table->decimal('price_taplab_rentel')->nullable();
            $table->integer('tax_rate')->nullable();
            $table->date('resigned_date')->nullable();
            $table->boolean('status')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->dateTime('deleted_at')->nullable();

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
        Schema::dropIfExists('motor_rentels');
    }
};
