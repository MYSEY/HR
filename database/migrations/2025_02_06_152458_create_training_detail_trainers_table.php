<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_02_06_152458_create_training_detail_trainers_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_detail_trainers', function (Blueprint $table) {
            $table->id();
            $table->string('training_id');
            $table->string('trainer_id');
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
        Schema::dropIfExists('training_detail_trainers');
    }
};
