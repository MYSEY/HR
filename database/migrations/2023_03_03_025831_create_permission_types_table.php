<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_03_03_025831_create_permission_types_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_types', function (Blueprint $table) {
            $table->id();
            $table->string('menu_id');
            $table->string('name');
            $table->string('icon');
            $table->string('is_all');
            $table->boolean('status');
            $table->timestamps();
        });

        DB::table('permission_types')->insert(
            [
                [
                    'menu_id'=>'1',
                    'name'=>'lang.dashboards',
                    'icon'=>'la la-dashboard',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'2',
                    'name'=>'lang.employee',
                    'icon'=>'la la-user',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                
                [
                    'menu_id'=>'3',
                    'name'=>'lang.recruitments',
                    'icon'=>'la la-briefcase',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'4',
                    'name'=>'lang.c&b',
                    'icon'=>'la la-money',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
             
                [
                    'menu_id'=>'5',
                    'name'=>'lang.motor_rentals',
                    'icon'=>'la la-motorcycle',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'6',
                    'name'=>'lang.trainings',
                    'icon'=>'la la-edit',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'7',
                    'name'=>'lang.reports',
                    'icon'=>'la la-pie-chart',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'8',
                    'name'=>'lang.configuration',
                    'icon'=>'la la-key',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'9',
                    'name'=>'lang.setting',
                    'icon'=>'la la-cog',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'10',
                    'name'=>'lang.leave',
                    'icon'=>'la la-calendar-check-o',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'11',
                    'name'=>'lang.address',
                    'icon'=>'la la-map-pin',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'12',
                    'name'=>'lang.performance_management',
                    'icon'=>'la la-tachometer-alt',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'13',
                    'name'=>'lang.exspanse_management',
                    'icon'=>'la la-money-bill',
                    'is_all'=>'1',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'menu_id'=>'14',
                    'name'=>'lang.role_permission',
                    'icon'=>'la la-key',
                    'is_all'=>'1',
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
        Schema::dropIfExists('permission_types');
    }
};
