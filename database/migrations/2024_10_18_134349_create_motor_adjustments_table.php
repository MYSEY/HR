<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2024_10_18_134349_create_motor_adjustments_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('motor_adjustments', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->decimal('amount_usd',50,2)->default(0)->nullable();
            $table->decimal('amount_kh',50,2)->default(0)->nullable();
            $table->decimal('amount_engine_oil',50,2)->default(0)->nullable();
            $table->date('adjustment_date');
            $table->string('adjustment_type')->nullable();
            $table->integer('tax_rate')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('motor_adjustments');
    }
};
