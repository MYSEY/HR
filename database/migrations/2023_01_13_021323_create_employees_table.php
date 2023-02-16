<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('number_employee')->nullable();
            $table->integer('department_id');
            $table->integer('branch_id');
            $table->string('position_id');
            $table->string('unit')->nullable();
            $table->string('level')->nullable();
            $table->string('employee_name_kh');
            $table->string('employee_name_en');
            $table->integer('gender')->nullable();
            $table->date('date_of_birth');
            $table->string('nationality')->nullable();
            $table->string('current_house_no')->nullable();
            $table->string('current_street_no')->nullable();
            $table->string('permanent_house_no')->nullable();
            $table->string('permanent_street_no')->nullable();
            $table->date('date_of_commencement')->nullable();
            $table->string('email');
            $table->longText('profile')->nullable();
            $table->longText('guarantee_letter')->nullable();
            $table->longText('employment_book')->nullable();
            $table->string('identity_type')->nullable();
            $table->integer('identity_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('issue_expired_date')->nullable();
            $table->string('current_addtress')->nullable();
            $table->string('permanent_addtress')->nullable();
            $table->string('company_phone_number')->nullable();
            $table->string('personal_phone_number')->nullable();
            $table->string('agency_phone_number')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('pass_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('fixed_dura_con_type')->nullable();
            $table->date('fdc_date')->nullable();
            $table->date('fdc_end')->nullable();
            $table->date('resign_date')->nullable();
            $table->string('resign_reason')->nullable();
            $table->string('remark')->nullable();
            $table->integer('number_of_children')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->boolean('active')->default(1);
            $table->string('status')->default('Probation');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
