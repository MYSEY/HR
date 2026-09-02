<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_11_07_063648_create_preview_national_social_security_funds_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preview_national_social_security_funds', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('number_employee')->nullable();
            $table->decimal('total_pre_tax_salary_usd',50,2)->default(0);
            $table->string('total_pre_tax_salary_riel',50,2)->default(0);
            $table->string('total_average_wage',50,2)->default(0);
            $table->string('total_occupational_risk',50,2)->default(0);
            $table->string('total_health_care',50,2)->default(0);
            $table->string('pension_contribution_usd',50,2)->default(0);
            $table->string('pension_contribution_riel',50,2)->default(0);
            $table->string('corporate_contribution',50,2)->default(0);
            $table->string('exchange_rate')->nullable();
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
        Schema::dropIfExists('preview_national_social_security_funds');
    }
};
