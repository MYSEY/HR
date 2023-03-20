<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('number_employee')->nullable();
            $table->string('employee_name_kh');
            $table->string('employee_name_en');
            $table->string('email')->unique();
            $table->string('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role_id')->nullable();
            $table->string('position_id')->nullable();
            $table->string('department_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->longText('profile')->nullable();
            $table->string('unit')->nullable();
            $table->string('level')->nullable();
            $table->integer('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->date('date_of_commencement')->nullable();
            $table->longText('guarantee_letter')->nullable();
            $table->longText('employment_book')->nullable();
            $table->string('identity_type')->nullable();
            $table->integer('identity_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('issue_expired_date')->nullable();
            $table->string('current_addtress')->nullable();
            $table->string('current_house_no')->nullable();
            $table->string('current_street_no')->nullable();
            $table->string('permanent_addtress')->nullable();
            $table->string('permanent_house_no')->nullable();
            $table->string('permanent_street_no')->nullable();
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
            $table->boolean('users_permission')->nullable();
            $table->string('status')->nullable();
            $table->string('emp_status')->default('Probation');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                'number_employee'=>'230-0001',
                'employee_name_kh'=>'Administrator',
                'employee_name_en'=>'Administrator',
                'email'=>'administrator@gmail.com',
                'password'=>Hash::make('ASDasd12345$$'),
                'role_id'=>'1',
                'users_permission'=>1,
                'status'=> 'Active',
                'profile'=>'',
                'created_at'=>now(),
                'updated_at'=>now(),
                'created_by'    => Auth::id(),
            ]
        );

        $tables=DB::select("select * from tables");
        foreach($tables as $value){
            for($i=1;$i<=6;$i++){
                DB::table('permissions')->insert(
                    [
                        'table_id'=>$value->id,
                        'role_id'=>1,
                        'permission_type_id'=>$i,
                        'status'=>1,
                        'created_at'=>now(),
                        'updated_at'=>now()
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
