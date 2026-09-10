<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_11_14_153222_create_annual_bonu_branches_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_bonu_branches', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('percentage');
            $table->year('year');
            $table->integer('number_of_months_bereceived')->nullable();
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
        Schema::dropIfExists('annual_bonu_branches');
    }
};
