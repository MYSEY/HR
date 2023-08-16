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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name')->nullable();
            $table->string('role_type')->nullable();
            $table->integer('status')->default(1);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::table('roles')->insert([
            [
                'role_name'=>'Developer',
                'role_type'=>'Admin',
                'status'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'role_name'=>'HR',
                'role_type'=>'Admin',
                'status'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ]]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
