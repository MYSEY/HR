<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  php artisan migrate:refresh --path=database/migrations/2025_03_31_084043_create_expense_request_histories_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('expense_request_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('expense_id');
            $table->string('tracking_id');
            $table->integer('type');
            $table->integer('expense_type');
            $table->string('kind_regard');
            $table->string('te_through')->nullable();
            $table->longText('subject');
            $table->string('reference');
            $table->longText('reason_subject')->nullable();
            $table->decimal('ge_cost_material_usd',50,2)->default(0);
            $table->decimal('ge_cost_material_riel',50,2)->default(0);
            $table->decimal('ge_cost_lso_usd',50,2)->default(0);
            $table->decimal('ge_cost_lso_riel',50,2)->default(0);
            $table->decimal('ge_total_cost_usd',50,2)->default(0);
            $table->decimal('ge_total_cost_riel',50,2)->default(0);
            $table->decimal('ge_tax_usd',50,2)->default(0);
            $table->decimal('tax_riel',50,2)->default(0);
            $table->decimal('ge_tax_fringe_benefit_usd',50,2)->default(0);
            $table->decimal('tax_fringe_benefit_riel',50,2)->default(0);
            $table->decimal('ge_vat_reverse_charge_usd',50,2)->default(0);
            $table->decimal('vat_reverse_charge_riel',50,2)->default(0);
            $table->decimal('ge_total_amount_usd',50,2)->default(0);
            $table->decimal('ge_total_amount_riel',50,2)->default(0);
            $table->string('payment_term');
            $table->decimal('te_payroll_tax_riel',50,2)->default(0);
            $table->decimal('te_tax_services',50,2)->default(0);
            $table->decimal('te_tax_interest',50,2)->default(0);
            $table->decimal('te_tax_non_resident',50,2)->default(0);
            $table->decimal('te_MTO_services',50,2)->default(0);
            $table->decimal('te_tax_wages',50,2)->default(0);
            $table->decimal('te_value_added',50,2)->default(0);
            $table->decimal('te_tax_income',50,2)->default(0);
            $table->decimal('te_total_tax',50,2)->default(0);
            $table->string('status')->nullable();
            $table->string('special')->nullable();
            $table->json('position_review')->nullable();
            $table->integer('review_type')->nullable();
            $table->integer('request_by');
            $table->integer('approve_by')->nullable();
            $table->dateTime('date_print')->nullable();
            $table->dateTime('date_request')->nullable();
            $table->dateTime('date_approve')->nullable();
            $table->dateTime('date_reject')->nullable();
            $table->longText('remark')->nullable();
            $table->longText('reason')->nullable();
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
        Schema::dropIfExists('expense_request_histories');
    }
};
