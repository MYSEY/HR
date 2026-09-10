<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_07_20_081641_create_generate_id_employees_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate_id_employees', function (Blueprint $table) {
            $table->id();
            $table->string('number_employee')->unique();
            $table->integer('employee_id')->nullable();
            $table->integer('candidate_resumes_id')->nullable();
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
        Schema::dropIfExists('generate_id_employees');
    }
};
