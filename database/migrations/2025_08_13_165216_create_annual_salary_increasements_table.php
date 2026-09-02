<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_08_13_165216_create_annual_salary_increasements_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_salary_increasements', function (Blueprint $table) {
            $table->id();
            $table->string('ranking_work_result');
            $table->string('total_score');
            $table->integer('percentage');
            $table->year('increasement_year');
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
        Schema::dropIfExists('annual_salary_increasements');
    }
};
