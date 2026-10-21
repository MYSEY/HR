<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_09_04_160758_create_form_rentals_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('form_rentals', function (Blueprint $table) {
            $table->id();
            $table->integer('rental_rates_id');
            $table->string('type');
            $table->string('title');
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('form_rentals');
    }
};
