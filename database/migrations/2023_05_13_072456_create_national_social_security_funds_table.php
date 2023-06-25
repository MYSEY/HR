<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('national_social_security_funds', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('total_pre_tax_salary_usd')->default(0);
            $table->string('total_pre_tax_salary_riel')->default(0);
            $table->string('total_average_wage')->default(0);
            $table->string('total_occupational_risk')->default(0);
            $table->string('total_health_care')->default(0);
            $table->string('pension_contribution_usd')->default(0);
            $table->string('pension_contribution_riel')->default(0);
            $table->string('corporate_contribution')->default(0);
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
        Schema::dropIfExists('national_social_security_funds');
    }
};
