<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_05_22_035700_create_recruitment_plans_table.php
     * 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('position_id');
            $table->string('branch_id');
            $table->date('plan_date');
            $table->integer('total_staff');
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
        Schema::dropIfExists('recruitment_plans');
    }
};
