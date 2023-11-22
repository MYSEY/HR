<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_07_18_081329_create_children_allowances_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children_allowances', function (Blueprint $table) {
            $table->id();
            $table->integer('total_children_allowance')->nullable();
            $table->integer('reduced_burden_children')->nullable();
            $table->integer('spouse_allowance')->nullable();
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
        Schema::dropIfExists('children_allowances');
    }
};
