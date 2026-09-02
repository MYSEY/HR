<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_03_10_155452_create_pa_purpose_histories_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('pa_purpose_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('pa_histories_id');
            $table->integer('title_histories_id');
            $table->string('name');
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
        Schema::dropIfExists('pa_purpose_histories');
    }
};
