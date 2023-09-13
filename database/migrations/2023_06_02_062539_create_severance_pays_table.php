<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_06_02_062539_create_severance_pays_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('severance_pays', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->decimal('total_severanec_pay',50,2)->nullable();
            $table->decimal('total_contract_severance_pay',50,2)->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('severance_pays');
    }
};
