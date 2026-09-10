<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_03_27_083138_create_transferreds_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferreds', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('tranferend_branch_name')->nullable();
            $table->string('position_id')->nullable();
            $table->string('tranferend_position_name')->nullable();
            $table->date('date')->nullable();
            $table->string('descrition')->nullable();
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
        Schema::dropIfExists('transferreds');
    }
};
