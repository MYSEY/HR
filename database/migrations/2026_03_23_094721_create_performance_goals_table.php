<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2026_03_23_094721_create_performance_goals_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_goals', function (Blueprint $table) {
            $table->id();
            $table->integer('performance_id');
            $table->integer('title_id');
            $table->integer('purpose_id');
            $table->integer('performance_detail_id');
            $table->integer('from');
            $table->integer('to');
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
        Schema::dropIfExists('performance_goals');
    }
};
