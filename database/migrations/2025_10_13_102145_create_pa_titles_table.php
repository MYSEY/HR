<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_10_13_102145_create_pa_titles_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pa_titles', function (Blueprint $table) {
            $table->id();
            $table->integer('performance_id');
            $table->string('title');
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
        Schema::dropIfExists('pa_titles');
    }
};
