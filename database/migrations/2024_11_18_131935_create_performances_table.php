<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('title_id');
            $table->integer('purpose_id');
            $table->string('key_kpi');
            $table->string('action_plan');
            $table->string('goal');
            $table->string('weight');
            $table->decimal('score_achieved')->nullable();
            $table->decimal('score')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('score_live_staff')->nullable();
            $table->decimal('score_direct_chairman')->nullable();
            $table->decimal('easy_difficult_factors')->nullable();
            $table->string('comment')->nullable();
            $table->decimal('total_weight')->nullable();
            $table->decimal('total_score_achieved')->nullable();
            $table->decimal('total_score')->nullable();
            $table->decimal('total_score_live_staff')->nullable();
            $table->decimal('total_score_direct_chairman')->nullable();
            $table->decimal('overall_results')->nullable();
            $table->decimal('score_level')->nullable();
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
        Schema::dropIfExists('performances');
    }
};
