<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2025_09_10_144742_create_salary_requests_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('salary_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->decimal('new_basic_salary');
            $table->date('request_date');
            $table->string('status');
            $table->integer('type')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('salary_requests');
    }
};
