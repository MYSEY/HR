<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2025_03_20_110806_create_fn_approvals_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('fn_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('employee_id');
            $table->integer('print_document_id')->nullable();
            $table->integer('location_id');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('fn_approvals');
    }
};
