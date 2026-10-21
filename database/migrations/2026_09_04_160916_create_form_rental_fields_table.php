<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_09_04_160916_create_form_rental_fields_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('form_rental_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('form_rental_id');
            $table->string('field_label');
            $table->string('field_type');
            $table->boolean('is_condition');
            $table->boolean('is_required');
            $table->json('options')->nullable();
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
        Schema::dropIfExists('form_rental_fields');
    }
};
