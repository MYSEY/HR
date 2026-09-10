<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2025_03_31_100038_create_generate_id_expenses_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('generate_id_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
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
        Schema::dropIfExists('generate_id_expenses');
    }
};
