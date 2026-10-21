<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_09_02_154810_create_bundled_rental_rates_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('bundled_rental_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
            $table->string('name');
            $table->string('type');
            $table->integer('position_id')->nullable();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('amount',50,2)->nullable()->default(0);
            $table->unsignedTinyInteger('transfer_day')->nullable();
            $table->integer("leave_day")->nullable();
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
        Schema::dropIfExists('bundled_rental_rates');
    }
};
