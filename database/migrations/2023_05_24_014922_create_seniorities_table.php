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
        Schema::create('seniorities', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->decimal('total_average_salary')->nullable();
            $table->string('total_salary_receive')->nullable();
            $table->string('tax_exemption_salary')->nullable();
            $table->string('taxable_salary')->nullable();
            $table->string('payment_of_month')->nullable();
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
        Schema::dropIfExists('seniorities');
    }
};
