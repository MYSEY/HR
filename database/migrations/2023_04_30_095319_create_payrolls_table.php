<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  php artisan migrate:refresh --path=database/migrations/2023_04_30_095319_create_payrolls_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('number_employee')->nullable();
            $table->decimal('basic_salary',50,2)->default(0);
            $table->decimal('total_gross_salary',50)->default(0);
            $table->date('payment_date')->nullable();
            $table->decimal('total_child_allowance',50,2)->default(0);
            $table->decimal('phone_allowance')->nullable();
            $table->decimal('monthly_quarterly_bonuses',50,2)->default(0);
            $table->decimal('total_kny_phcumben',50,2)->default(0);
            $table->decimal('annual_incentive_bonus',50,2)->default(0);
            $table->decimal('total_gross',50,2)->default(0);
            $table->decimal('total_pension_fund',50,2)->default(0);
            $table->decimal('seniority_pay_included_tax',50,2)->default(0);
            $table->decimal('base_salary_received_usd',50,2)->default(0);
            $table->string('base_salary_received_riel')->nullable();
            $table->integer('spouse')->default(0);
            $table->integer('children')->default(0);
            $table->string('total_charges_reduced')->nullable();
            $table->string('total_tax_base_riel',50,2)->default(0);
            $table->integer('total_rate')->default(0);
            $table->decimal('total_salary_tax_usd',50,2)->default(0);
            $table->string('total_salary_tax_riel',50,2)->default(0);
            $table->decimal('total_amount_reduced',50,2)->default(0);
            $table->decimal('seniority_pay_excluded_tax',50,2)->default(0);
            $table->decimal('seniority_backford',50,2)->default(0);
            $table->decimal('total_severance_pay',50,2)->default(0);
            $table->float('loan_amount',50,2)->nullable();
            $table->float('total_amount_car',50,2)->nullable();
            $table->decimal('total_salary',50,2)->default(0);
            $table->string('exchange_rate')->nullable();
            $table->string('adjustment')->nullable();
            $table->string('leaves')->nullable();
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
