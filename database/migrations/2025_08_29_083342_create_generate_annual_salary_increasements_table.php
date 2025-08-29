<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_08_29_083342_create_generate_annual_salary_increasements_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate_annual_salary_increasements', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('performance_id');
            $table->decimal('basic_salary',50,2)->default(0);
            $table->decimal('salary_increasement',50,2)->default(0);
            $table->string('increasement_of_year');
            $table->integer('percentage');
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
        Schema::dropIfExists('generate_annual_salary_increasements');
    }
};
