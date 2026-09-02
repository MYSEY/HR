<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2025_09_04_094949_create_performance_histories_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('performance_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('performance_id');
            $table->integer('employee_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('kpi_form');
            $table->integer('total_weight')->default(0);
            $table->decimal('total_score')->default(0);
            $table->decimal('total_score_live_staff')->default(0);
            $table->decimal('total_score_direct_chairman')->default(0);
            $table->string('type')->nullable();
            $table->string('remark')->nullable();
            $table->string('status')->nullable();
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_date')->nullable();
            //**  Process review and approve */
            $table->integer('review_employee_id')->nullable();
            $table->string('location_review')->nullable();
            $table->json('position_review')->nullable();
            $table->dateTime('review_date')->nullable();
            $table->integer('approve_by')->nullable();
            $table->dateTime('approve_date')->nullable();
            $table->dateTime('reject_date')->nullable();
            $table->longText('reason')->nullable();
            // ** end */
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
        Schema::dropIfExists('performance_histories');
    }
};
