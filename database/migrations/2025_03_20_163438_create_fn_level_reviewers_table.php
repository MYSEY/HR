<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2025_03_20_163438_create_fn_level_reviewers_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('fn_level_reviewers', function (Blueprint $table) {
            $table->id();
            $table->integer('from_amount')->default(0);
            $table->integer('to_amount')->default(0);
            $table->integer('request_type');
            $table->integer('type');
            $table->integer('from_location');
            $table->integer('department_review')->nullable();
            $table->json('id_positions');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('fn_level_reviewers');
    }
};
