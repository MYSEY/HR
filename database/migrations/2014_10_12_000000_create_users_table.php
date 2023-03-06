<?php

use Illuminate\Support\Facades\DB;
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
            $table->string('name');
            $table->string('email');
            $table->string('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id')->nullable();
            $table->string('profile')->nullable();
            $table->boolean('users_permission')->nullable();
            $table->boolean('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                'name'=>'Administrator',
                'email'=>'administrator@gmail.com',
                'password'=>Hash::make('ASDasd12345$$'),
                'role_id'=>1,
                'users_permission'=>1,
                'status'=>1,
                'profile'=>'profiles/admin_user.jpg',
                'created_at'=>now(),
                'updated_at'=>now()
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
