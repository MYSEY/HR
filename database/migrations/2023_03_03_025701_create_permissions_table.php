<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=database/migrations/2023_03_03_025701_create_permissions_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('menu_id')->nullable();
            $table->string('sub_menu_id')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->integer('role_id');
            $table->integer('parent_id');
            $table->json('is_dashboard',200)->nullable();
            $table->boolean('is_all')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_create')->nullable();
            $table->boolean('is_view')->nullable();
            $table->boolean('is_update')->nullable();
            $table->boolean('is_delete')->nullable();
            $table->boolean('is_cancel')->nullable();
            $table->boolean('is_accept')->nullable();
            $table->boolean('is_approve')->nullable();
            $table->boolean('is_print')->nullable();
            $table->boolean('is_import')->nullable();
            $table->boolean('is_export')->nullable();
            $table->boolean('is_access')->nullable();
            $table->boolean('is_view_report')->nullable();
            $table->boolean('is_operation')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('permissions');
    }
};
