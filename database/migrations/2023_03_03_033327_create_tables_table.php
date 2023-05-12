<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status');
            $table->timestamps();
        });
        DB::table('tables')->insert(
            [
                [
                    'name'=>'Dashboard Admin',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Dashboard Employee',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Employee',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Employee Salary',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Motor Rental',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Roles & Permissions',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Holidays',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Leaves',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Department',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Position',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Branch',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Leaves Employee',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
};
