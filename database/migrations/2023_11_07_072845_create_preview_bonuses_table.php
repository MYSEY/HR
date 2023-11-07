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
        Schema::create('preview_bonuses', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('number_employee')->nullable();
            $table->string('number_of_working_days')->nullable();
            $table->decimal('base_salary',50,2)->default(0);
            $table->decimal('base_salary_received',50,2)->default(0);
            $table->decimal('total_allowance',50,2)->default(0);
            $table->string('bouns_type')->nullable();
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
        Schema::dropIfExists('preview_bonuses');
    }
};
