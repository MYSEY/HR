<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan migrate:refresh --path=database/migrations/2026_01_19_102837_create_fn_amount_approvals_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('fn_amount_approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('fn_approval_id')->nullable();
            $table->integer('level_reviewer_id');
            $table->integer('location');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('fn_amount_approvals');
    }
};
