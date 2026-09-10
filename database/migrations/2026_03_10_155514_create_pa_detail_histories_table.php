<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_03_10_155514_create_pa_detail_histories_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('pa_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('pa_histories_id');
            $table->string('title_histories_id');
            $table->string('purpose_histories_id');
            $table->longText('key_kpi');
            $table->longText('action_plan');
            $table->string('goal')->nullable();
            $table->string('goal_type')->nullable();
            $table->string('progress')->nullable();
            $table->string('weight');
            $table->integer('score_achieved')->nullable();
            $table->decimal('score')->nullable();
            $table->decimal('score_live_staff')->nullable();
            $table->decimal('score_direct_chairman')->nullable();
            $table->string('easy_difficult_factors')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('is_lock')->default(false);
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
        Schema::dropIfExists('pa_detail_histories');
    }
};
