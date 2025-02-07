<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_11_18_131935_create_performances_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('overall_results')->nullable();
            $table->decimal('score_level')->nullable();
            $table->decimal('total_weight')->nullable();
            $table->decimal('total_score_achieved')->nullable();
            $table->decimal('total_score')->nullable();
            $table->decimal('total_score_live_staff')->nullable();
            $table->decimal('total_score_direct_chairman')->nullable();
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
