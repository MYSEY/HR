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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('leave_type_id');
            $table->integer('request_to');
            $table->integer('handover_staff_id')->nullable();
            $table->date('start_date');
            $table->string('start_half_day')->nullable();
            $table->date('end_date');
            $table->string('end_half_day')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('next_approver')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('status');
            $table->string('number_of_day')->nullable();
            $table->string('total_annual_leave')->nullable();
            $table->string('total_sick_leave')->nullable();
            $table->string('total_special_leave')->nullable();
            $table->string('total_unpaid_leave')->nullable();
            $table->string('reason')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('leave_requests');
    }
};
