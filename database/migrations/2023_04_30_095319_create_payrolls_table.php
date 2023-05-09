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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->decimal('net_salary')->default(0);
            $table->integer('spouse')->nullable();
            $table->decimal('payment_amount')->nullable();
            $table->decimal('total_child_allowance')->nullable();
            $table->decimal('phone_allowance')->nullable();
            $table->decimal('monthly_quarterly_bonuses')->nullable();
            $table->integer('khmer_new_year_pchum_ben_allowance')->nullable();
            $table->integer('annual_incentive_bonus')->nullable();
            $table->decimal('total_gross_salary')->nullable();
            $table->decimal('base_salary_received_usd')->nullable();
            $table->string('base_salary_received_riel')->nullable();
            $table->decimal('total_amount_reduced')->nullable();
            $table->integer('total_rate')->nullable();
            $table->decimal('seniority_allowance_tax')->nullable();
            $table->decimal('pension_contribution')->nullable();
            $table->string('total_charges_reduced')->nullable();
            $table->string('total_tax_base_riel')->nullable();
            $table->decimal('total_salary_tax_usd')->nullable();
            $table->string('total_salary_tax_riel')->nullable();
            $table->decimal('total_tax_seniority')->nullable();
            $table->decimal('other_allowances')->nullable();
            $table->decimal('total_salary')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
};