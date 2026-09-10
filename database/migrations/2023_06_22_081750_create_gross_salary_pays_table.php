<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_06_22_081750_create_gross_salary_pays_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gross_salary_pays', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->string('number_employee')->nullable();
            $table->decimal('basic_salary',50,2)->default(0);
            $table->decimal('total_gross_salary',50,2)->default(0);
            $table->decimal('total_fdc1',50,2)->default(0);
            $table->string('type_fdc1')->nullable();
            $table->decimal('total_fdc2',50,2)->default(0);
            $table->string('type_fdc2')->nullable();
            $table->string('type_udc')->nullable();
            $table->decimal('total_seniority')->nullable();
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
        Schema::dropIfExists('gross_salary_pays');
    }
};
