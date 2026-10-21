<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_09_30_100147_create_special_approve_leave_histories_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('special_approve_leave_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('under_approve');
            $table->integer('employee_id');
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
        Schema::dropIfExists('special_approve_leave_histories');
    }
};
