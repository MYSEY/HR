<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_11_10_100850_create_generate_annaul_bonuses_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate_annaul_bonuses', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('performance_id');
            $table->decimal('basice_salary',50,2)->default(0);
            $table->integer('working_days_per_year')->nullable();
            $table->integer('incentive')->nullable();
            $table->integer('pa_score')->nullable();
            $table->integer('of_incentive_by_pa')->nullable();
            $table->integer('achieved_vs_pa')->nullable();
            $table->integer('number_months_received')->nullable();
            $table->decimal('total_bounus',50,2)->default(0);
            $table->string('status')->nullable();
            $table->string('increasement_of_year');
            $table->bigInteger('approved_by')->unsigned()->nullable();
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
        Schema::dropIfExists('generate_annaul_bonuses');
    }
};
