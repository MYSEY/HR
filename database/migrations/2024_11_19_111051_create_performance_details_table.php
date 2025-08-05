<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_11_19_111051_create_performance_details_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_details', function (Blueprint $table) {
            $table->id();
            $table->integer('performance_id');
            $table->string('title_id');
            $table->string('purpose_id');
            $table->longText('key_kpi');
            $table->longText('action_plan');
            $table->string('goal');
            $table->string('goal_type')->nullable();
            $table->string('progress')->nullable();
            $table->string('weight');
            $table->decimal('score_achieved')->nullable();
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
        Schema::dropIfExists('performance_details');
    }
};
