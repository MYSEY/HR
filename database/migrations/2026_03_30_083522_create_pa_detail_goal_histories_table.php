<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_03_30_083522_create_pa_detail_goal_histories_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('pa_detail_goal_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('pa_histories_id');
            $table->string('title_histories_id');
            $table->string('purpose_histories_id');
            $table->integer('pa_detail_histories_id');
            $table->string('from');
            $table->string('to');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('pa_detail_goal_histories');
    }
};
