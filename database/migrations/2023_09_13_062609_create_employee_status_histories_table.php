<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * php artisan migrate:refresh --path=database/migrations/2023_09_13_062609_create_employee_status_histories_table.php
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_status_histories', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('status')->nullable();
            $table->date('status_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('employee_status_histories');
    }
};
