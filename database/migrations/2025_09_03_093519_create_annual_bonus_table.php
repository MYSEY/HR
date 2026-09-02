<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_09_03_093519_create_annual_bonus_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_bonus', function (Blueprint $table) {
            $table->id();
            $table->string('criteria');
            $table->string('discription');
            $table->string('total_score');
            $table->integer('percentage');
            $table->year('increasement_year');
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
        Schema::dropIfExists('annual_bonus');
    }
};
