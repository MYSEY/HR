<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_09_18_151952_create_payment_rentals_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('payment_rentals', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('location_id');
            $table->string('motor_rental_id');
            $table->decimal('total_amount_khr',50,4);
            $table->decimal('total_amount_usd',50,4);
            $table->decimal('total_leave_amount_khr',50,4)->nullable();
            $table->decimal('total_leave_amount_usd',50,4)->nullable();
            $table->decimal('total_tax_fee_khr',50,4);
            $table->decimal('total_tax_fee_usd',50,4);
            $table->decimal('total_adjust_amount_excl',50,4)->nullable();
            $table->decimal('total_adjust_amount_incl',50,4)->nullable();
            $table->decimal('total_adjust_tax_fee',50,4)->nullable();
            $table->decimal('total_adjust_amount_khr',50,4)->nullable();
            $table->decimal('total_net_amount_khr',50,4);
            $table->decimal('total_net_amount_usd',50,4);
            $table->date('resigned_date')->nullable();
            $table->date('from_date');
            $table->date('to_date');
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
        Schema::dropIfExists('payment_rentals');
    }
};
