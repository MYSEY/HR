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
        Schema::create('permission_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status');
            $table->timestamps();
        });

        DB::table('permission_types')->insert(
            [
                [
                    'name'=>'View',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Add',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Update',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Delete',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Import',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'name'=>'Export',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]
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
        Schema::dropIfExists('permission_types');
    }
};
