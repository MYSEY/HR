<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffPromotedsTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_01_23_032147_create_staff_promoteds_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_promoteds', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->text('posit_id')->nullable();
            $table->text('position_promoted_to')->nullable();
            $table->text('depart_id')->nullable();
            $table->text('department_promoted_to')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('staff_promoteds');
    }
}
