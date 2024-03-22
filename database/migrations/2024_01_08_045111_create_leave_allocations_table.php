<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_01_08_045111_create_leave_allocations_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('leave_allocations', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('default_annual_leave')->nullable();
            $table->string('default_sick_leave')->nullable();
            $table->string('default_special_leave')->nullable();
            $table->string('default_unpaid_leave')->nullable();
            $table->string('total_annual_leave')->nullable();
            $table->string('total_sick_leave')->nullable();
            $table->string('total_special_leave')->nullable();
            $table->string('total_unpaid_leave')->nullable();
            $table->string('year_1')->nullable();
            $table->string('year_2')->nullable();
            $table->string('year_3')->nullable();
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
        Schema::dropIfExists('leave_allocations');
    }
};
