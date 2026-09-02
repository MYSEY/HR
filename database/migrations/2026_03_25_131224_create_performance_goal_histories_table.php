<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_03_25_131224_create_performance_goal_histories_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('performance_goal_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('performance_histories_id');
            $table->integer('title_histories_id');
            $table->integer('purpose_histories_id');
            $table->integer('performance_detail_histories_id');
            $table->string('from');
            $table->string('to');
            $table->integer('user_id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('performance_goal_histories');
    }
};
