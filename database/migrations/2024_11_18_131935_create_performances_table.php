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
            $table->date('from_date');
            $table->date('to_date');
            $table->decimal('total_score')->default(0);
            $table->decimal('total_score_achieved')->default(0);
            $table->decimal('overall_results')->default(0);
            $table->decimal('total_score_live_staff')->default(0);
            $table->decimal('total_score_direct_chairman')->default(0);
            $table->string('type')->nullable();
            $table->string('status')->nullable();
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
