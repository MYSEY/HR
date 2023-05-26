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
            $table->decimal('basic_salary')->default(0);
            $table->decimal('payment_amount')->nullable();
            $table->decimal('total_gross_salary')->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('total_child_allowance')->nullable();
            $table->decimal('phone_allowance')->nullable();
            $table->decimal('monthly_quarterly_bonuses')->nullable();
            $table->integer('annual_incentive_bonus')->nullable();
            $table->decimal('other_allowances')->nullable();
            $table->decimal('seniority_payable_tax')->nullable();
            $table->decimal('base_salary_received_usd')->nullable();
            $table->string('base_salary_received_riel')->nullable();
            $table->integer('spouse')->nullable();
            $table->integer('children')->nullable();
            $table->decimal('total_amount_reduced')->nullable();
            $table->decimal('pension_contribution')->nullable();
            $table->string('total_charges_reduced')->nullable();
            $table->string('total_tax_base_riel')->nullable();
            $table->decimal('total_salary_tax_usd')->nullable();
            $table->string('total_salary_tax_riel')->nullable();
            $table->integer('total_rate')->nullable();
            $table->decimal('tax_free_seniority_allowance')->nullable();
            $table->decimal('total_salary')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
};
