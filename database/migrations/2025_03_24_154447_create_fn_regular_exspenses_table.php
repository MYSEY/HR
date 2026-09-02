<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2025_03_24_154447_create_fn_regular_exspenses_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('fn_regular_exspenses', function (Blueprint $table) {
            $table->id();
            $table->string('serialref');
            $table->string('description');
            $table->longText('file_upload')->nullable();
            $table->integer('is_contactual')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('fn_regular_exspenses');
    }
};
