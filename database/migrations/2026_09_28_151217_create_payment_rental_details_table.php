<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_09_28_151217_create_payment_rental_details_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('payment_rental_details', function (Blueprint $table) {
            $table->id();
            $table->string('payment_rental_id');
            $table->integer("position_id")->nullable();
            $table->json('fields');
            $table->string('type')->nullable();
            $table->string('currency');
            $table->decimal('price',50,4);
            $table->date('terminate_date')->nullable();
            $table->string('status')->nullable();
            $table->decimal('total_leave_days',50,4)->nullable();
            $table->decimal('total_work_day',50,4);
            $table->integer('tax_rate');
            $table->decimal('amount',50,4);
            $table->decimal('amount_excl_tax',50,4);
            $table->decimal('leave_amount',50,4);
            $table->decimal('tax_fee',50,4);
            $table->decimal('adjust_amount_excl',50,4)->nullable();
            $table->decimal('adjust_amount_incl',50,4)->nullable();
            $table->decimal('adjust_tax_fee',50,4)->nullable();
            $table->decimal('adjust_amount_khr',50,4)->nullable();
            $table->decimal('net_amount',50,4);
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
        Schema::dropIfExists('payment_rental_details');
    }
};
