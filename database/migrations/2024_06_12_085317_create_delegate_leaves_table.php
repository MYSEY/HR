<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2024_06_12_085317_create_delegate_leaves_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegate_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('requester_id');
            $table->integer('delegate_id')->nullable();
            $table->string('number_of_day')->nullable();
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('delegate_leaves');
    }
};
